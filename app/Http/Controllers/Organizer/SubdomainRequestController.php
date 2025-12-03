<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\SubdomainRequest;
use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubdomainRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Afficher la liste des demandes de sous-domaines de l'organisateur
     */
    public function index()
    {
        $requests = SubdomainRequest::where('user_id', auth()->id())
            ->with(['user', 'approver'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Charger les contenus séparément pour éviter les problèmes de morphTo
        foreach ($requests as $request) {
            if ($request->content_type === 'event' && $request->content_id) {
                $event = \App\Models\Event::find($request->content_id);
                $request->setRelation('event', $event);
            } elseif ($request->content_type === 'contest' && $request->content_id) {
                $contest = \App\Models\Contest::find($request->content_id);
                $request->setRelation('contest', $contest);
            } elseif ($request->content_type === 'fundraising' && $request->content_id) {
                $fundraising = \App\Models\Fundraising::find($request->content_id);
                $request->setRelation('fundraising', $fundraising);
            }
        }

        return view('dashboard.organizer.subdomain-requests.index', compact('requests'));
    }

    /**
     * Afficher le formulaire de demande
     */
    public function create(Request $request)
    {
        $contentType = $request->query('type'); // event, contest, fundraising
        $contentId = $request->query('id');

        // Récupérer les événements, concours et collectes de l'organisateur
        $events = Event::where('organizer_id', auth()->id())
            ->where('is_published', true)
            ->where(function($query) {
                $query->whereNull('subdomain')
                      ->orWhere('subdomain_enabled', false);
            })
            ->get();
        
        $contests = Contest::where('organizer_id', auth()->id())
            ->where('is_published', true)
            ->where(function($query) {
                $query->whereNull('subdomain')
                      ->orWhere('subdomain_enabled', false);
            })
            ->get();
        
        $fundraisings = Fundraising::where('organizer_id', auth()->id())
            ->where('is_published', true)
            ->where(function($query) {
                $query->whereNull('subdomain')
                      ->orWhere('subdomain_enabled', false);
            })
            ->get();

        return view('dashboard.organizer.subdomain-requests.create', compact(
            'events',
            'contests',
            'fundraisings',
            'contentType',
            'contentId'
        ));
    }

    /**
     * Enregistrer une nouvelle demande
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content_type' => 'required|in:event,contest,fundraising',
            'content_id' => 'required|integer',
            'requested_subdomain' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-z0-9-]+$/',
                function ($attribute, $value, $fail) {
                    // Vérifier que le sous-domaine n'est pas déjà utilisé
                    $exists = SubdomainRequest::where('requested_subdomain', $value)
                        ->whereIn('status', ['pending', 'approved', 'completed'])
                        ->exists();
                    
                    if ($exists) {
                        $fail('Ce sous-domaine est déjà demandé ou utilisé.');
                    }

                    // Vérifier dans les tables events, contests, fundraisings
                    $eventExists = \App\Models\Event::where('subdomain', $value)->exists();
                    $contestExists = \App\Models\Contest::where('subdomain', $value)->exists();
                    $fundraisingExists = \App\Models\Fundraising::where('subdomain', $value)->exists();
                    
                    if ($eventExists || $contestExists || $fundraisingExists) {
                        $fail('Ce sous-domaine est déjà utilisé.');
                    }
                },
            ],
            'reason' => 'nullable|string|max:1000',
        ]);

        // Vérifier que le contenu appartient à l'organisateur
        $content = null;
        if ($validated['content_type'] === 'event') {
            $content = Event::where('id', $validated['content_id'])
                ->where('organizer_id', auth()->id())
                ->firstOrFail();
        } elseif ($validated['content_type'] === 'contest') {
            $content = Contest::where('id', $validated['content_id'])
                ->where('organizer_id', auth()->id())
                ->firstOrFail();
        } elseif ($validated['content_type'] === 'fundraising') {
            $content = Fundraising::where('id', $validated['content_id'])
                ->where('organizer_id', auth()->id())
                ->firstOrFail();
        }

        // Vérifier qu'il n'y a pas déjà une demande en cours pour ce contenu
        $existingRequest = SubdomainRequest::where('content_type', $validated['content_type'])
            ->where('content_id', $validated['content_id'])
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'Une demande est déjà en cours pour ce contenu.');
        }

        // Normaliser le sous-domaine (minuscules, pas d'espaces)
        $validated['requested_subdomain'] = Str::lower(Str::slug($validated['requested_subdomain']));
        $validated['user_id'] = auth()->id();

        SubdomainRequest::create($validated);

        return redirect()->route('organizer.subdomain-requests.index')
            ->with('success', 'Votre demande de sous-domaine a été soumise avec succès. Elle sera examinée par un administrateur.');
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show(SubdomainRequest $subdomainRequest)
    {
        // Vérifier que la demande appartient à l'utilisateur
        if ($subdomainRequest->user_id !== auth()->id()) {
            abort(403);
        }

        $subdomainRequest->load(['approver']);
        
        // Charger le contenu en fonction du type
        if ($subdomainRequest->content_type === 'event' && $subdomainRequest->content_id) {
            $event = \App\Models\Event::find($subdomainRequest->content_id);
            $subdomainRequest->setRelation('event', $event);
        } elseif ($subdomainRequest->content_type === 'contest' && $subdomainRequest->content_id) {
            $contest = \App\Models\Contest::find($subdomainRequest->content_id);
            $subdomainRequest->setRelation('contest', $contest);
        } elseif ($subdomainRequest->content_type === 'fundraising' && $subdomainRequest->content_id) {
            $fundraising = \App\Models\Fundraising::find($subdomainRequest->content_id);
            $subdomainRequest->setRelation('fundraising', $fundraising);
        }

        return view('dashboard.organizer.subdomain-requests.show', compact('subdomainRequest'));
    }
}
