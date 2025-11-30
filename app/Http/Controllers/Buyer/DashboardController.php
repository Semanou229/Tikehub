<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Event;
use App\Models\Vote;
use App\Models\Donation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        // Statistiques générales
        $totalTickets = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->count();

        $upcomingTickets = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('start_date', '>=', now());
            })
            ->count();

        $pastTickets = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('end_date', '<', now());
            })
            ->count();

        $virtualTickets = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('is_virtual', true)
                  ->where('start_date', '>=', now());
            })
            ->count();

        $totalSpent = Payment::where('user_id', $userId)
            ->where('status', 'completed')
            ->sum('amount');

        // Tickets à venir
        $upcomingTicketsList = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('start_date', '>=', now())
                  ->where('is_published', true);
            })
            ->with(['event', 'ticketType', 'payment'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Événements passés
        $pastTicketsList = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('end_date', '<', now());
            })
            ->with(['event', 'ticketType', 'payment'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Événements virtuels à venir
        $virtualEventsTickets = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('is_virtual', true)
                  ->where('start_date', '>=', now())
                  ->where('is_published', true);
            })
            ->with(['event', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Historique des paiements (6 derniers mois)
        $monthlySpending = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthSpending = Payment::where('user_id', $userId)
                ->where('status', 'completed')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');

            $monthlySpending[] = [
                'month' => $month->format('M Y'),
                'amount' => (float) $monthSpending,
            ];
        }

        // Derniers paiements
        $recentPayments = Payment::where('user_id', $userId)
            ->with(['event', 'paymentable'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Répartition par catégorie
        $categorySpending = Ticket::where('buyer_id', $userId)
            ->where('status', 'paid')
            ->with('event')
            ->get()
            ->groupBy('event.category')
            ->map(function ($tickets) {
                return $tickets->sum('price');
            });

        $stats = [
            'total_tickets' => $totalTickets,
            'upcoming_tickets' => $upcomingTickets,
            'past_tickets' => $pastTickets,
            'virtual_tickets' => $virtualTickets,
            'total_spent' => $totalSpent,
            'monthly_spending' => $monthlySpending,
            'category_spending' => $categorySpending,
        ];

        return view('dashboard.buyer.index', compact(
            'stats',
            'upcomingTicketsList',
            'pastTicketsList',
            'virtualEventsTickets',
            'recentPayments'
        ));
    }

    public function tickets(Request $request)
    {
        $user = auth()->user();
        
        // Onglets avec compteurs
        $ticketsCount = Ticket::where('buyer_id', $user->id)
            ->where('status', 'paid')
            ->count();
            
        $votesCount = Vote::where('user_id', $user->id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->count();
            
        $donationsCount = Donation::where('user_id', $user->id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'completed');
            })
            ->count();
        
        // Déterminer l'onglet actif
        $activeTab = $request->get('tab', 'tickets');
        
        // Billets
        $tickets = collect();
        if ($activeTab === 'tickets') {
            $query = Ticket::where('buyer_id', $user->id)
                ->where('status', 'paid')
                ->with(['event', 'ticketType', 'payment']);

            // Filtres
            if ($request->filled('status')) {
                if ($request->status === 'upcoming') {
                    $query->whereHas('event', function ($q) {
                        $q->where('start_date', '>=', now());
                    });
                } elseif ($request->status === 'past') {
                    $query->whereHas('event', function ($q) {
                        $q->where('end_date', '<', now());
                    });
                } elseif ($request->status === 'virtual') {
                    $query->whereHas('event', function ($q) {
                        $q->where('is_virtual', true);
                    });
                }
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('event', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            }

            $tickets = $query->orderBy('created_at', 'desc')->paginate(12);
        }
        
        // Votes
        $votes = collect();
        if ($activeTab === 'votes') {
            $query = Vote::where('user_id', $user->id)
                ->whereHas('payment', function($q) {
                    $q->where('status', 'completed');
                })
                ->with(['contest', 'candidate', 'payment']);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('contest', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            }

            $votes = $query->orderBy('created_at', 'desc')->paginate(12);
        }
        
        // Dons
        $donations = collect();
        if ($activeTab === 'donations') {
            $query = Donation::where('user_id', $user->id)
                ->whereHas('payment', function($q) {
                    $q->where('status', 'completed');
                })
                ->with(['fundraising', 'payment']);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->whereHas('fundraising', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            }

            $donations = $query->orderBy('created_at', 'desc')->paginate(12);
        }
        
        return view('dashboard.buyer.tickets', compact(
            'tickets',
            'votes',
            'donations',
            'ticketsCount',
            'votesCount',
            'donationsCount',
            'activeTab'
        ));
    }

    public function payments()
    {
        $user = auth()->user();
        $payments = Payment::where('user_id', $user->id)
            ->with(['event', 'paymentable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('dashboard.buyer.payments', compact('payments'));
    }

    public function virtualEvents()
    {
        $user = auth()->user();
        $tickets = Ticket::where('buyer_id', $user->id)
            ->where('status', 'paid')
            ->whereHas('event', function ($q) {
                $q->where('is_virtual', true)
                  ->where('is_published', true);
            })
            ->with(['event', 'ticketType'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('dashboard.buyer.virtual-events', compact('tickets'));
    }
}
