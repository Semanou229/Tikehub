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

        // Revenus des 6 derniers mois
        $monthlyRevenue = Payment::whereHas('tickets.event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })
        ->where('status', 'completed')
        ->select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->limit(6)
        ->get();

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
}

