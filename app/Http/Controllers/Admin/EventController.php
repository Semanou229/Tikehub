<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function create()
    {
        $organizers = User::role('organizer')->get();
        return view('dashboard.admin.events.create', compact('organizers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Musique,Sport,Culture,Art,Business,Éducation,Santé,Technologie,Gastronomie,Divertissement,Famille,Mode,Autre',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_city' => 'nullable|string|max:255',
            'venue_country' => 'nullable|string|max:255',
            'venue_latitude' => 'nullable|numeric|between:-90,90',
            'venue_longitude' => 'nullable|numeric|between:-180,180',
            'cover_image' => 'nullable|image|max:2048',
            'organizer_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'status' => 'nullable|in:draft,published,cancelled,completed',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['status'] = $request->input('status', 'draft');
        $validated['type'] = 'other';
        
        // Gestion du sous-domaine
        if ($request->has('subdomain_enabled') && $request->subdomain_enabled) {
            $validated['subdomain_enabled'] = true;
            if ($request->filled('subdomain')) {
                $validated['subdomain'] = Str::slug($request->subdomain);
            } else {
                $validated['subdomain'] = Str::slug($validated['title']);
            }
        } else {
            $validated['subdomain_enabled'] = false;
            $validated['subdomain'] = null;
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event = Event::create($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Événement créé avec succès.');
    }

    public function edit(Event $event)
    {
        $organizers = User::role('organizer')->get();
        return view('dashboard.admin.events.edit', compact('event', 'organizers'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Musique,Sport,Culture,Art,Business,Éducation,Santé,Technologie,Gastronomie,Divertissement,Famille,Mode,Autre',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_city' => 'nullable|string|max:255',
            'venue_country' => 'nullable|string|max:255',
            'venue_latitude' => 'nullable|numeric|between:-90,90',
            'venue_longitude' => 'nullable|numeric|between:-180,180',
            'cover_image' => 'nullable|image|max:2048',
            'organizer_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'status' => 'nullable|in:draft,published,cancelled,completed',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['status'] = $request->input('status', $event->status);
        
        // Gestion du sous-domaine
        if ($request->has('subdomain_enabled') && $request->subdomain_enabled) {
            $validated['subdomain_enabled'] = true;
            if ($request->filled('subdomain')) {
                $validated['subdomain'] = Str::slug($request->subdomain);
            } elseif (empty($event->subdomain)) {
                $validated['subdomain'] = Str::slug($validated['title']);
            }
        } else {
            $validated['subdomain_enabled'] = false;
        }

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Événement mis à jour avec succès.');
    }
}

