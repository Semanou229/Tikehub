<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('organizer');

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('published')) {
            $query->where('is_published', $request->published === '1');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $events = $query->latest()->paginate(20);

        return view('dashboard.admin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['organizer', 'ticketTypes', 'tickets', 'agents']);
        
        $stats = [
            'total_tickets' => $event->tickets()->where('status', 'paid')->count(),
            'total_revenue' => $event->tickets()->where('status', 'paid')->sum('price'),
            'scanned_tickets' => $event->tickets()
                ->where('status', 'paid')
                ->whereHas('scans', function ($q) {
                    $q->where('is_valid', true);
                })
                ->count(),
        ];

        return view('dashboard.admin.events.show', compact('event', 'stats'));
    }

    public function approve(Event $event)
    {
        $event->update([
            'is_published' => true,
            'status' => 'published',
        ]);

        return back()->with('success', 'Événement approuvé et publié.');
    }

    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $event->update([
            'is_published' => false,
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Événement rejeté.');
    }

    public function suspend(Event $event)
    {
        $event->update([
            'is_published' => false,
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Événement suspendu.');
    }
}

