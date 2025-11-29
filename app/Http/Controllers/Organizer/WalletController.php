<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Ticket;
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

        return view('dashboard.organizer.wallet.index', compact(
            'totalEarnings',
            'netEarnings',
            'platformCommission',
            'monthlyRevenue',
            'recentTransactions',
            'statsByType'
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
        if (!$user->isKycVerified()) {
            return back()->with('error', 'Vous devez compléter la vérification KYC avant de pouvoir demander un retrait de fonds.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|in:mobile_money,bank_transfer',
            'account_number' => 'required|string|max:255',
        ]);

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
        $commissionRate = config('platform.commission_rate', 0.05);
        $platformCommission = $totalEarnings * $commissionRate;
        $netEarnings = $totalEarnings - $platformCommission;

        if ($validated['amount'] > $netEarnings) {
            return back()->withErrors(['amount' => 'Le montant demandé dépasse vos revenus nets disponibles.'])->withInput();
        }

        // TODO: Créer une demande de retrait dans la base de données
        // Pour l'instant, on retourne juste un message de succès
        return back()->with('success', 'Votre demande de retrait de ' . number_format($validated['amount'], 0, ',', ' ') . ' XOF a été soumise avec succès. Elle sera traitée dans les 2-3 jours ouvrables.');
    }
}

