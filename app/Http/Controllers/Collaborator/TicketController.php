<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Vote;
use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function index(Request $request)
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
        
        return view('dashboard.collaborator.tickets.index', compact(
            'tickets',
            'votes',
            'donations',
            'ticketsCount',
            'votesCount',
            'donationsCount',
            'activeTab'
        ));
    }
}

