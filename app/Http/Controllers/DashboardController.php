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
        $events = Event::where('organizer_id', auth()->id())
            ->withCount(['tickets', 'ticketTypes'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_events' => Event::where('organizer_id', auth()->id())->count(),
            'total_sales' => Ticket::whereHas('event', function ($q) {
                $q->where('organizer_id', auth()->id());
            })->where('status', 'paid')->sum('price'),
            'total_tickets' => Ticket::whereHas('event', function ($q) {
                $q->where('organizer_id', auth()->id());
            })->where('status', 'paid')->count(),
        ];

        return view('dashboard.organizer', compact('events', 'stats'));
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

