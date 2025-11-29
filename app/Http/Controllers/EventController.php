<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\GeocodingService;
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

            // Filtre par recherche
            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }

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

            if ($request->filled('virtual')) {
                $query->where('is_virtual', $request->input('virtual') === 'true');
            }

            // Filtre par prix minimum
            if ($request->filled('price_min')) {
                $query->whereHas('ticketTypes', function($q) use ($request) {
                    $q->where('is_active', true)
                      ->where('price', '>=', $request->input('price_min'));
                });
            }

            if ($request->filled('price_max')) {
                $query->whereHas('ticketTypes', function($q) use ($request) {
                    $q->where('is_active', true)
                      ->where('price', '<=', $request->input('price_max'));
                });
            }

            // Filtre par organisateur
            if ($request->filled('organizer')) {
                $query->where('organizer_id', $request->input('organizer'));
            }

            // Tri
            $sortBy = $request->input('sort', 'date_desc');
            switch ($sortBy) {
                case 'date_asc':
                    $query->orderBy('start_date', 'asc');
                    break;
                case 'price_asc':
                    $query->join('ticket_types', 'events.id', '=', 'ticket_types.event_id')
                          ->where('ticket_types.is_active', true)
                          ->select('events.*')
                          ->groupBy('events.id')
                          ->orderByRaw('MIN(ticket_types.price) ASC');
                    break;
                case 'price_desc':
                    $query->join('ticket_types', 'events.id', '=', 'ticket_types.event_id')
                          ->where('ticket_types.is_active', true)
                          ->select('events.*')
                          ->groupBy('events.id')
                          ->orderByRaw('MIN(ticket_types.price) DESC');
                    break;
                case 'popular':
                    $query->withCount('tickets')->orderBy('tickets_count', 'desc');
                    break;
                case 'date_desc':
                default:
                    $query->orderBy('start_date', 'desc');
                    break;
            }

            $events = $query->with('organizer')->with('ticketTypes')->paginate(12)->withQueryString();

            // Récupérer les organisateurs et catégories pour les filtres
            $organizers = \App\Models\User::whereHas('events', function($q) {
                $q->where('is_published', true)->where('status', 'published');
            })->get();

            $categories = Event::where('is_published', true)
                ->where('status', 'published')
                ->distinct()
                ->pluck('category')
                ->filter()
                ->sort()
                ->values();

            return view('events.index', compact('events'));
        } catch (\Exception $e) {
            \Log::error('Error in EventController@index: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            $events = Event::where('is_published', true)
                ->where('status', 'published')
                ->with('organizer')
                ->with('ticketTypes')
                ->orderBy('start_date', 'desc')
                ->paginate(12);

            $organizers = \App\Models\User::whereHas('events', function($q) {
                $q->where('is_published', true)->where('status', 'published');
            })->get();

            $categories = Event::where('is_published', true)
                ->where('status', 'published')
                ->distinct()
                ->pluck('category')
                ->filter()
                ->sort()
                ->values();

            return view('events.index', compact('events', 'organizers', 'categories'));
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

    public function store(Request $request, GeocodingService $geocoding)
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:Musique,Sport,Culture,Art,Business,Éducation,Santé,Technologie,Gastronomie,Divertissement,Famille,Mode,Autre',
            'is_virtual' => 'nullable|boolean',
            'platform_type' => 'required_if:is_virtual,1|nullable|in:google_meet,zoom,teams,webex,other',
            'meeting_link' => 'required_if:is_virtual,1|nullable|url|max:500',
            'meeting_id' => 'nullable|string|max:255',
            'meeting_password' => 'nullable|string|max:255',
            'virtual_access_instructions' => 'nullable|string|max:2000',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'venue_city' => 'nullable|string|max:255',
            'venue_country' => 'nullable|string|max:255',
            'venue_latitude' => 'nullable|numeric|between:-90,90',
            'venue_longitude' => 'nullable|numeric|between:-180,180',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Si les coordonnées ne sont pas fournies mais qu'une adresse, ville ou pays existe, géocoder
        if (empty($validated['venue_latitude']) && empty($validated['venue_longitude'])) {
            // Prioriser l'adresse pour le géocodage
            $addressToGeocode = null;
            if (!empty($validated['venue_address'])) {
                $addressToGeocode = $validated['venue_address'];
            } elseif (!empty($validated['venue_city'])) {
                $addressToGeocode = $validated['venue_city'];
            } elseif (!empty($validated['venue_country'])) {
                $addressToGeocode = $validated['venue_country'];
            }
            
            if ($addressToGeocode) {
                $fullAddress = $geocoding->buildAddress(
                    $validated['venue_address'] ?? null,
                    $validated['venue_city'] ?? null,
                    $validated['venue_country'] ?? null
                );
                
                $geocoded = $geocoding->geocode($fullAddress);
                
                if ($geocoded) {
                    $validated['venue_latitude'] = $geocoded['latitude'];
                    $validated['venue_longitude'] = $geocoded['longitude'];
                    
                    // Compléter les informations manquantes si disponibles
                    if (isset($geocoded['details'])) {
                        if (empty($validated['venue_city']) && isset($geocoded['details']['city'])) {
                            $validated['venue_city'] = $geocoded['details']['city'];
                        } elseif (empty($validated['venue_city']) && isset($geocoded['details']['town'])) {
                            $validated['venue_city'] = $geocoded['details']['town'];
                        }
                        if (empty($validated['venue_country']) && isset($geocoded['details']['country'])) {
                            $validated['venue_country'] = $geocoded['details']['country'];
                        }
                    }
                }
            }
        }

        // Si toujours pas de coordonnées, utiliser des valeurs par défaut (Cotonou)
        if (empty($validated['venue_latitude']) || empty($validated['venue_longitude'])) {
            $validated['venue_latitude'] = 6.4969;
            $validated['venue_longitude'] = 2.6283;
        }

        $validated['organizer_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_published'] = false;
        $validated['status'] = 'draft';
        $validated['type'] = 'other'; // Valeur par défaut puisque le type n'est plus utilisé
        $validated['is_virtual'] = $request->has('is_virtual') && $request->is_virtual == '1';
        
        // Si l'événement n'est pas virtuel, ne pas exiger les champs de lieu
        if (!$validated['is_virtual']) {
            // Si toujours pas de coordonnées, utiliser des valeurs par défaut (Cotonou)
            if (empty($validated['venue_latitude']) || empty($validated['venue_longitude'])) {
                $validated['venue_latitude'] = 6.4969;
                $validated['venue_longitude'] = 2.6283;
            }
        }
        
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

    public function update(Request $request, Event $event, GeocodingService $geocoding)
    {
        $this->authorize('update', $event);

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

        // Si les coordonnées ne sont pas fournies mais qu'une adresse, ville ou pays existe, géocoder
        if (empty($validated['venue_latitude']) && empty($validated['venue_longitude'])) {
            // Prioriser l'adresse pour le géocodage
            $addressToGeocode = null;
            if (!empty($validated['venue_address'])) {
                $addressToGeocode = $validated['venue_address'];
            } elseif (!empty($validated['venue_city'])) {
                $addressToGeocode = $validated['venue_city'];
            } elseif (!empty($validated['venue_country'])) {
                $addressToGeocode = $validated['venue_country'];
            }
            
            if ($addressToGeocode) {
                $fullAddress = $geocoding->buildAddress(
                    $validated['venue_address'] ?? null,
                    $validated['venue_city'] ?? null,
                    $validated['venue_country'] ?? null
                );
                
                $geocoded = $geocoding->geocode($fullAddress);
                
                if ($geocoded) {
                    $validated['venue_latitude'] = $geocoded['latitude'];
                    $validated['venue_longitude'] = $geocoded['longitude'];
                    
                    // Compléter les informations manquantes si disponibles
                    if (isset($geocoded['details'])) {
                        if (empty($validated['venue_city']) && isset($geocoded['details']['city'])) {
                            $validated['venue_city'] = $geocoded['details']['city'];
                        } elseif (empty($validated['venue_city']) && isset($geocoded['details']['town'])) {
                            $validated['venue_city'] = $geocoded['details']['town'];
                        }
                        if (empty($validated['venue_country']) && isset($geocoded['details']['country'])) {
                            $validated['venue_country'] = $geocoded['details']['country'];
                        }
                    }
                }
            }
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

