<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubdomainRequest;
use App\Models\Event;
use App\Models\Contest;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class SubdomainRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Afficher la liste de toutes les demandes
     */
    public function index(Request $request)
    {
        $query = SubdomainRequest::with(['user', 'approver']);

        // Filtres
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('content_type') && $request->content_type !== '') {
            $query->where('content_type', $request->content_type);
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(20);
        
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

        $stats = [
            'pending' => SubdomainRequest::where('status', 'pending')->count(),
            'approved' => SubdomainRequest::where('status', 'approved')->count(),
            'completed' => SubdomainRequest::where('status', 'completed')->count(),
            'rejected' => SubdomainRequest::where('status', 'rejected')->count(),
        ];

        return view('dashboard.admin.subdomain-requests.index', compact('requests', 'stats'));
    }

    /**
     * Afficher les détails d'une demande
     */
    public function show(SubdomainRequest $subdomainRequest)
    {
        $subdomainRequest->load(['user', 'approver']);
        
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

        return view('dashboard.admin.subdomain-requests.show', compact('subdomainRequest'));
    }

    /**
     * Approuver une demande
     */
    public function approve(Request $request, SubdomainRequest $subdomainRequest)
    {
        if ($subdomainRequest->status !== 'pending') {
            return back()->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $subdomainRequest->update([
            'status' => 'approved',
            'admin_notes' => $validated['admin_notes'] ?? null,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'La demande a été approuvée. Vous pouvez maintenant créer le sous-domaine sur cPanel.');
    }

    /**
     * Rejeter une demande
     */
    public function reject(Request $request, SubdomainRequest $subdomainRequest)
    {
        if ($subdomainRequest->status !== 'pending') {
            return back()->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ]);

        $subdomainRequest->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'La demande a été rejetée.');
    }

    /**
     * Compléter une demande (après création manuelle sur cPanel)
     */
    public function complete(Request $request, SubdomainRequest $subdomainRequest)
    {
        if ($subdomainRequest->status !== 'approved') {
            return back()->with('error', 'Seules les demandes approuvées peuvent être complétées.');
        }

        $validated = $request->validate([
            'actual_subdomain' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-z0-9-]+$/',
                function ($attribute, $value, $fail) use ($subdomainRequest) {
                    // Vérifier que le sous-domaine n'est pas déjà utilisé
                    $eventExists = Event::where('subdomain', $value)
                        ->where('id', '!=', $subdomainRequest->content_type === 'event' ? $subdomainRequest->content_id : 0)
                        ->exists();
                    $contestExists = Contest::where('subdomain', $value)
                        ->where('id', '!=', $subdomainRequest->content_type === 'contest' ? $subdomainRequest->content_id : 0)
                        ->exists();
                    $fundraisingExists = Fundraising::where('subdomain', $value)
                        ->where('id', '!=', $subdomainRequest->content_type === 'fundraising' ? $subdomainRequest->content_id : 0)
                        ->exists();
                    
                    if ($eventExists || $contestExists || $fundraisingExists) {
                        $fail('Ce sous-domaine est déjà utilisé par un autre contenu.');
                    }
                },
            ],
        ]);

        // Associer le sous-domaine au contenu
        $content = null;
        if ($subdomainRequest->content_type === 'event') {
            $content = Event::findOrFail($subdomainRequest->content_id);
        } elseif ($subdomainRequest->content_type === 'contest') {
            $content = Contest::findOrFail($subdomainRequest->content_id);
        } elseif ($subdomainRequest->content_type === 'fundraising') {
            $content = Fundraising::findOrFail($subdomainRequest->content_id);
        }

        if ($content) {
            $content->update([
                'subdomain' => strtolower($validated['actual_subdomain']),
                'subdomain_enabled' => true,
            ]);
        }

        // Mettre à jour la demande
        $subdomainRequest->update([
            'status' => 'completed',
            'actual_subdomain' => strtolower($validated['actual_subdomain']),
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Le sous-domaine a été associé avec succès. Il est maintenant actif.');
    }
}
