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

        // Rediriger les collaborateurs (agents ou membres d'équipe) vers leur dashboard
        if ($user->isAgent() || $user->team_id !== null) {
            return redirect()->route('collaborator.dashboard');
        }

        return $this->buyerDashboard();
    }

    protected function adminDashboard()
    {
        return redirect()->route('admin.dashboard');
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

        // Concours (tous les concours de l'organisateur)
        $contests = \App\Models\Contest::where('organizer_id', $organizerId)
            ->withCount('votes')
            ->withCount('candidates')
            ->latest()
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

        // Statistiques événements virtuels
        $virtualEvents = Event::where('organizer_id', $organizerId)
            ->where('is_virtual', true)
            ->get();
        
        $virtualStats = [
            'total_virtual_events' => $virtualEvents->count(),
            'total_virtual_participants' => 0,
            'total_virtual_accesses' => 0,
        ];
        
        foreach ($virtualEvents as $event) {
            $eventStats = app(\App\Services\VirtualEventService::class)->getAccessStatistics($event);
            $virtualStats['total_virtual_participants'] += $eventStats['unique_participants'];
            $virtualStats['total_virtual_accesses'] += $eventStats['total_accesses'];
        }

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

            // Revenus des billets d'événements
            $eventRevenue = Ticket::whereHas('event', function ($query) use ($organizerId) {
                $query->where('organizer_id', $organizerId);
            })
            ->where('status', 'paid')
            ->whereBetween('created_at', [$monthStart, $monthEnd])
            ->sum('price');

            // Revenus des votes (concours)
            $contestRevenue = Payment::where('paymentable_type', \App\Models\Contest::class)
                ->whereHas('paymentable', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('organizer_amount');

            // Revenus des dons (collectes)
            $fundraisingRevenue = Payment::where('paymentable_type', \App\Models\Fundraising::class)
                ->whereHas('paymentable', function ($query) use ($organizerId) {
                    $query->where('organizer_id', $organizerId);
                })
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('organizer_amount');

            $totalMonthRevenue = $eventRevenue + $contestRevenue + $fundraisingRevenue;

            $monthlyRevenue[] = [
                'month' => $month->format('M Y'),
                'revenue' => (float) $totalMonthRevenue,
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
            'virtual_stats' => $virtualStats,
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
        return redirect()->route('buyer.dashboard');
    }
}

