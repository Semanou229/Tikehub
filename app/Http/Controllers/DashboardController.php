<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isOrganizer()) {
            return $this->organizerDashboard();
        }

        if ($user->isAgent()) {
            return $this->agentDashboard();
        }

        return $this->buyerDashboard();
    }

    protected function adminDashboard()
    {
        $stats = [
            'total_events' => Event::count(),
            'total_users' => \App\Models\User::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('platform_commission'),
            'pending_kyc' => \App\Models\User::where('kyc_status', 'pending')->count(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    protected function organizerDashboard()
    {
        $user = auth()->user();
        $organizerId = $user->id;

        // Événements
        $events = Event::where('organizer_id', $organizerId)
            ->withCount(['tickets', 'ticketTypes'])
            ->latest()
            ->take(10)
            ->get();

        // Concours
        $contests = \App\Models\Contest::where('organizer_id', $organizerId)
            ->withCount('votes')
            ->latest()
            ->take(5)
            ->get();

        // Collectes
        $fundraisings = \App\Models\Fundraising::where('organizer_id', $organizerId)
            ->latest()
            ->take(5)
            ->get();

        // Statistiques générales
        $totalEvents = Event::where('organizer_id', $organizerId)->count();
        $activeEvents = Event::where('organizer_id', $organizerId)
            ->where('is_published', true)
            ->where('start_date', '>=', now())
            ->count();
        $completedEvents = Event::where('organizer_id', $organizerId)
            ->where('end_date', '<', now())
            ->count();

        // Revenus des billets
        $totalSales = Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'paid')->sum('price');

        // Revenus des votes
        $totalVoteRevenue = Payment::where('paymentable_type', \App\Models\Contest::class)
            ->whereHas('paymentable', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->where('status', 'completed')
            ->sum('organizer_amount');

        // Revenus des dons
        $totalDonationRevenue = Payment::where('paymentable_type', \App\Models\Fundraising::class)
            ->whereHas('paymentable', function ($q) use ($organizerId) {
                $q->where('organizer_id', $organizerId);
            })
            ->where('status', 'completed')
            ->sum('organizer_amount');

        $totalRevenue = $totalSales + $totalVoteRevenue + $totalDonationRevenue;

        // Billets
        $totalTickets = Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'paid')->count();

        // Paiements en attente
        $pendingPayments = Payment::where(function ($q) use ($organizerId) {
            $q->whereHas('event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })->orWhereHas('paymentable', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            });
        })->where('status', 'pending')->count();

        // Revenus des 6 derniers mois
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $revenue = Payment::where(function ($q) use ($organizerId) {
                $q->whereHas('event', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })->orWhereHas('paymentable', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                });
            })
            ->where('status', 'completed')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('organizer_amount');

            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue,
            ];
        }

        // Répartition des revenus
        $revenueDistribution = [
            'events' => $totalSales,
            'contests' => $totalVoteRevenue,
            'fundraisings' => $totalDonationRevenue,
        ];

        $stats = [
            'total_events' => $totalEvents,
            'active_events' => $activeEvents,
            'completed_events' => $completedEvents,
            'total_sales' => $totalSales,
            'total_revenue' => $totalRevenue,
            'total_tickets' => $totalTickets,
            'pending_payments' => $pendingPayments,
            'monthly_revenue' => $monthlyRevenue,
            'revenue_distribution' => $revenueDistribution,
        ];

        return view('dashboard.organizer', compact('events', 'contests', 'fundraisings', 'stats'));
    }

    protected function agentDashboard()
    {
        $events = auth()->user()->agentEvents()->latest()->take(10)->get();
        return view('dashboard.agent', compact('events'));
    }

    protected function buyerDashboard()
    {
        $tickets = Ticket::where('buyer_id', auth()->id())
            ->with(['event', 'ticketType'])
            ->latest()
            ->paginate(10);

        return view('dashboard.buyer', compact('tickets'));
    }
}

