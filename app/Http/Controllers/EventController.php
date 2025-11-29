<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Event::where('is_published', true)
                ->where('status', 'published');

            // Filtres
            if ($request->filled('category')) {
                $query->where('category', $request->input('category'));
            }

            if ($request->filled('date_from')) {
                $query->where('start_date', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $query->where('start_date', '<=', $request->input('date_to'));
            }

            if ($request->filled('location')) {
                $query->where('venue_city', 'like', '%' . $request->input('location') . '%');
            }

            if ($request->filled('free')) {
                $query->where('is_free', $request->input('free') === 'true');
            }

            $events = $query->orderBy('start_date', 'desc')->paginate(12);

            return view('events.index', compact('events'));
        } catch (\Exception $e) {
            \Log::error('Error in EventController@index: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            $events = Event::where('is_published', true)
                ->where('status', 'published')
                ->orderBy('start_date', 'desc')
                ->paginate(12);
            return view('events.index', compact('events'));
        }
    }

    public function show(Event $event)
    {
        // Vérifier si l'événement est publié ou si l'utilisateur est l'organisateur
        $userId = auth()->id();
        if (!$event->is_published && $event->status !== 'published') {
            // Si l'événement n'est pas publié, seul l'organisateur peut le voir
            if (!$userId || $event->organizer_id !== $userId) {
                abort(404);
            }
        }

        $event->load(['ticketTypes', 'contests', 'fundraisings', 'organizer']);

        return view('events.show', compact('event'));
    }

    public function create()
    {
        // Vérifier l'authentification
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour créer un événement.');
        }
        
        // Vérifier l'autorisation
        if (!auth()->user()->hasRole('organizer') && !auth()->user()->hasRole('admin')) {
            abort(403, 'Accès réservé aux organisateurs.');
        }
        
        return view('events.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'type' => 'required|in:concert,competition,fundraising,contest,other',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_city' => 'nullable|string|max:255',
            'venue_country' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = false;
        $validated['status'] = 'draft';
        
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

        return redirect()->route('events.edit', $event)->with('success', 'Événement créé avec succès');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_city' => 'nullable|string|max:255',
            'venue_country' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        
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
                Storage::disk('public')->delete($event->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('events.edit', $event)->with('success', 'Événement mis à jour');
    }

    public function publish(Event $event)
    {
        $this->authorize('publish', $event);

        $event->update([
            'is_published' => true,
            'status' => 'published',
        ]);

        return back()->with('success', 'Événement publié');
    }
}

