<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_events' => Event::count(),
            'published_events' => Event::where('is_published', true)->count(),
            'draft_events' => Event::where('is_published', false)->count(),
            'total_users' => User::count(),
            'total_organizers' => User::role('organizer')->count(),
            'total_agents' => User::role('agent')->count(),
            'total_buyers' => User::role('buyer')->count(),
            'pending_kyc' => User::where('kyc_status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('platform_commission'),
            'total_transactions' => Payment::where('status', 'completed')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_tickets_sold' => Ticket::where('status', 'paid')->count(),
            'total_contests' => Contest::count(),
            'active_contests' => Contest::where('is_active', true)->where('end_date', '>=', now())->count(),
            'total_fundraisings' => Fundraising::count(),
            'active_fundraisings' => Fundraising::where('is_active', true)->where('end_date', '>=', now())->count(),
        ];

        // Revenus des 6 derniers mois
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $revenue = Payment::where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('platform_commission');

            $monthlyRevenue[] = [
                'month' => $month->format('Y-m'),
                'revenue' => (float) $revenue,
            ];
        }

        // Répartition des revenus par type
        $revenueByType = [
            'events' => Payment::whereHas('tickets', function ($q) {
                $q->where('status', 'paid');
            })->where('status', 'completed')->sum('platform_commission') ?? 0,
            'contests' => Payment::whereHas('votes', function ($q) {
                $q->whereHas('contest');
            })->where('status', 'completed')->sum('platform_commission') ?? 0,
            'fundraisings' => Payment::whereHas('donation', function ($q) {
                $q->whereHas('fundraising');
            })->where('status', 'completed')->sum('platform_commission') ?? 0,
        ];

        // Événements récents
        $recentEvents = Event::with('organizer')
            ->latest()
            ->take(10)
            ->get();

        // Utilisateurs récents
        $recentUsers = User::with('roles')
            ->latest()
            ->take(10)
            ->get();

        // KYC en attente
        $pendingKyc = User::where('kyc_status', 'pending')
            ->with('roles')
            ->latest('kyc_submitted_at')
            ->take(10)
            ->get();

        // Transactions récentes
        $recentPayments = Payment::with(['user', 'tickets.event', 'votes.contest', 'donation.fundraising'])
            ->latest()
            ->take(10)
            ->get();

        // Top organisateurs (par nombre d'événements)
        $topOrganizers = User::role('organizer')
            ->withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.admin.index', compact(
            'stats',
            'monthlyRevenue',
            'revenueByType',
            'recentEvents',
            'recentUsers',
            'pendingKyc',
            'recentPayments',
            'topOrganizers'
        ));
    }
}

