<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Withdrawal;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $organizerId = $user->id;

        // Revenus totaux (billets vendus)
        $totalRevenue = Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'paid')->sum('price');

        // Revenus des concours (votes payants)
        $contestRevenue = Payment::whereHas('votes.contest', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'completed')->sum('amount');

        // Revenus des collectes (dons)
        $fundraisingRevenue = Payment::whereHas('donation', function ($q) use ($organizerId) {
            $q->whereHas('fundraising', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            });
        })->where('status', 'completed')->sum('amount');

        // Total des revenus
        $totalEarnings = $totalRevenue + $contestRevenue + $fundraisingRevenue;

        // Commission plateforme (généralement 5-10%)
        $commissionRate = config('platform.commission_rate', 0.05);
        $platformCommission = $totalEarnings * $commissionRate;
        $netEarnings = $totalEarnings - $platformCommission;

        // Revenus des 6 derniers mois (tous types confondus)
        $monthlyRevenue = Payment::where(function ($q) use ($organizerId) {
            $q->whereHas('tickets.event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->orWhereHas('votes', function ($query) use ($organizerId) {
                $query->whereHas('contest', function ($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                });
            })
            ->orWhereHas('donation', function ($query) use ($organizerId) {
                $query->whereHas('fundraising', function ($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                });
            });
        })
        ->where('status', 'completed')
        ->where('created_at', '>=', now()->subMonths(6))
        ->select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();
        
        // Remplir les mois manquants avec 0
        $last6Months = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $last6Months[$month] = 0;
        }
        
        foreach ($monthlyRevenue as $revenue) {
            $last6Months[$revenue->month] = (float) $revenue->total;
        }
        
        $monthlyRevenue = collect($last6Months)->map(function ($total, $month) {
            return (object) ['month' => $month, 'total' => $total];
        })->values();

        // Transactions récentes
        $recentTransactions = Payment::where(function ($q) use ($organizerId) {
            $q->whereHas('tickets.event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->orWhereHas('votes', function ($query) use ($organizerId) {
                $query->whereHas('contest', function ($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                });
            })
            ->orWhereHas('donation', function ($query) use ($organizerId) {
                $query->whereHas('fundraising', function ($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                });
            });
        })
        ->where('status', 'completed')
        ->with(['tickets.event', 'votes.contest', 'donation.fundraising', 'user'])
        ->latest()
        ->paginate(20);

        // Statistiques par type
        $statsByType = [
            'events' => [
                'total' => $totalRevenue,
                'count' => Ticket::whereHas('event', function ($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })->where('status', 'paid')->count(),
            ],
            'contests' => [
                'total' => $contestRevenue,
                'count' => Payment::whereHas('votes', function ($q) use ($organizerId) {
                    $q->whereHas('contest', function ($query) use ($organizerId) {
                        $query->where('organizer_id', $organizerId);
                    });
                })->where('status', 'completed')->count(),
            ],
            'fundraisings' => [
                'total' => $fundraisingRevenue,
                'count' => Payment::whereHas('donation', function ($q) use ($organizerId) {
                    $q->whereHas('fundraising', function ($query) use ($organizerId) {
                        $query->where('organizer_id', $organizerId);
                    });
                })->where('status', 'completed')->count(),
            ],
        ];

        // Demandes de retrait
        $withdrawals = Withdrawal::where('user_id', $organizerId)
            ->latest()
            ->paginate(10);

        return view('dashboard.organizer.wallet.index', compact(
            'totalEarnings',
            'netEarnings',
            'platformCommission',
            'monthlyRevenue',
            'recentTransactions',
            'statsByType',
            'withdrawals'
        ));
    }

    public function withdraw(Request $request)
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur est un organisateur
        if (!$user->isOrganizer()) {
            abort(403, 'Accès réservé aux organisateurs.');
        }

        // Vérifier que le KYC est vérifié
        $kycRequired = PlatformSetting::get('kyc_required_for_withdrawal', true);
        if ($kycRequired && !$user->isKycVerified()) {
            return back()->with('error', 'Vous devez compléter la vérification KYC avant de pouvoir demander un retrait de fonds.');
        }

        // Règles de validation selon la méthode de paiement
        $rules = [
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:mobile_money,bank_transfer,crypto',
        ];

        $minAmount = PlatformSetting::get('min_withdrawal_amount', 1000);
        $maxAmount = PlatformSetting::get('max_withdrawal_amount', 10000000);
        
        $rules['amount'] .= "|min:{$minAmount}|max:{$maxAmount}";

        // Validation selon la méthode de paiement
        if ($request->payment_method === 'mobile_money') {
            $rules['mobile_network'] = 'required|string|max:50';
            $rules['country_code'] = 'required|string|max:10';
            $rules['phone_number'] = 'required|string|max:20';
        } elseif ($request->payment_method === 'bank_transfer') {
            $rules['bank_name'] = 'required|string|max:255';
            $rules['account_number'] = 'required|string|max:255';
            $rules['account_holder_name'] = 'required|string|max:255';
            $rules['iban'] = 'nullable|string|max:50';
            $rules['swift_code'] = 'nullable|string|max:20';
        } elseif ($request->payment_method === 'crypto') {
            $rules['crypto_currency'] = 'required|string|max:20';
            $rules['crypto_wallet_address'] = 'required|string|max:255';
            $rules['crypto_network'] = 'nullable|string|max:50';
        }

        $validated = $request->validate($rules);

        $organizerId = $user->id;

        // Calculer les revenus nets disponibles
        $totalRevenue = Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'paid')->sum('price');

        $contestRevenue = Payment::whereHas('votes.contest', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'completed')->sum('amount');

        $fundraisingRevenue = Payment::whereHas('donation', function ($q) use ($organizerId) {
            $q->whereHas('fundraising', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            });
        })->where('status', 'completed')->sum('amount');

        $totalEarnings = $totalRevenue + $contestRevenue + $fundraisingRevenue;
        $commissionRate = PlatformSetting::get('commission_rate', 5) / 100;
        $platformCommission = $totalEarnings * $commissionRate;
        $netEarnings = $totalEarnings - $platformCommission;

        // Vérifier les retraits en attente
        $pendingWithdrawals = Withdrawal::where('user_id', $organizerId)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        $availableBalance = $netEarnings - $pendingWithdrawals;

        if ($validated['amount'] > $availableBalance) {
            return back()->withErrors(['amount' => 'Le montant demandé dépasse votre solde disponible. Solde disponible: ' . number_format($availableBalance, 0, ',', ' ') . ' XOF'])->withInput();
        }

        // Créer la demande de retrait
        $withdrawal = Withdrawal::create([
            'user_id' => $organizerId,
            'amount' => $validated['amount'],
            'currency' => 'XOF',
            'payment_method' => $validated['payment_method'],
            'mobile_network' => $validated['mobile_network'] ?? null,
            'country_code' => $validated['country_code'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'account_holder_name' => $validated['account_holder_name'] ?? null,
            'iban' => $validated['iban'] ?? null,
            'swift_code' => $validated['swift_code'] ?? null,
            'crypto_currency' => $validated['crypto_currency'] ?? null,
            'crypto_wallet_address' => $validated['crypto_wallet_address'] ?? null,
            'crypto_network' => $validated['crypto_network'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Votre demande de retrait de ' . number_format($validated['amount'], 0, ',', ' ') . ' XOF a été soumise avec succès. Elle sera traitée dans les ' . PlatformSetting::get('withdrawal_processing_days', 3) . ' jours ouvrables.');
    }
}

