<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $query = Contest::where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());

        // Filtre par prix par vote
        if ($request->filled('price_min')) {
            $query->where('price_per_vote', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price_per_vote', '<=', $request->input('price_max'));
        }

        // Filtre par date de fin
        if ($request->filled('end_date_from')) {
            $query->where('end_date', '>=', $request->input('end_date_from'));
        }
        if ($request->filled('end_date_to')) {
            $query->where('end_date', '<=', $request->input('end_date_to'));
        }

        // Filtre par nombre de votes (popularité)
        if ($request->filled('min_votes')) {
            $query->has('votes', '>=', $request->input('min_votes'));
        }

        // Filtre par organisateur
        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->input('organizer'));
        }

        // Tri
        $sortBy = $request->input('sort', 'popular');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price_per_vote', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_vote', 'desc');
                break;
            case 'end_date':
                $query->orderBy('end_date', 'asc');
                break;
            case 'popular':
            default:
                $query->withCount('votes')->orderBy('votes_count', 'desc');
                break;
        }

        $contests = $query->with('organizer')->paginate(12)->withQueryString();

        // Récupérer les organisateurs pour le filtre
        $organizers = \App\Models\User::whereHas('contests', function($q) {
            $q->where('is_published', true)->where('is_active', true);
        })->get();

        return view('contests.index', compact('contests', 'organizers'));
    }

    public function show(Contest $contest)
    {
        if (!$contest->is_published && $contest->organizer_id !== auth()->id()) {
            abort(404);
        }

        // Charger les candidats avec leurs votes et points (seulement les votes payés)
        $candidates = $contest->candidates()
            ->withSum(['votes as votes_sum_points' => function($query) {
                $query->whereHas('payment', function($q) {
                    $q->where('status', 'completed');
                });
            }], 'points')
            ->orderBy('votes_sum_points', 'desc')
            ->get();

        // Classement avec position
        $ranking = $candidates->map(function($candidate, $index) {
            $candidate->position = $index + 1;
            $candidate->total_points = (int)($candidate->votes_sum_points ?? 0);
            return $candidate;
        });

        $contest->load(['organizer', 'event']);

        return view('contests.show', compact('contest', 'candidates', 'ranking'));
    }

    public function vote(Request $request, Contest $contest, ContestCandidate $candidate)
    {
        if (!$contest->isActive()) {
            return back()->with('error', 'Ce concours n\'est plus actif');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour voter');
        }

            try {
            $voteService = app(\App\Services\VoteService::class);
            $payment = $voteService->castVote(
                auth()->user(),
                $candidate,
                $request->quantity,
                $request->ip()
            );

            // Récupérer l'URL de checkout depuis la session ou Moneroo
            $checkoutUrl = session('moneroo_checkout_url_' . $payment->id);
            if ($checkoutUrl) {
                session()->forget('moneroo_checkout_url_' . $payment->id);
                return redirect($checkoutUrl);
            }

            // Si pas d'URL en session, essayer de récupérer depuis Moneroo
            if ($payment->moneroo_transaction_id) {
                try {
                    $monerooService = app(\App\Services\MonerooService::class);
                    $monerooPayment = $monerooService->getPayment($payment->moneroo_transaction_id);
                    $checkoutUrl = $monerooPayment->checkout_url ?? $monerooPayment->checkoutUrl ?? null;
                    if ($checkoutUrl) {
                        return redirect($checkoutUrl);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error getting checkout URL for vote', ['error' => $e->getMessage()]);
                }
            }

            return redirect()->route('contests.show', $contest)->with('error', 'Erreur lors de la création du paiement');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $this->authorize('create', Contest::class);
        return view('contests.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Contest::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'price_per_vote' => 'required|numeric|min:0',
            'points_per_vote' => 'required|integer|min:1',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'cover_image' => 'nullable|image|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'candidates' => 'nullable|array',
            'candidates.*.name' => 'required_with:candidates|string|max:255',
            'candidates.*.number' => 'required_with:candidates|integer|min:1',
            'candidates.*.description' => 'nullable|string',
            'candidates.*.photo' => 'nullable|image|max:2048',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['is_published'] = false;
        $validated['is_active'] = true;
        
        // Gestion du sous-domaine
        if ($request->has('subdomain_enabled') && $request->subdomain_enabled) {
            $validated['subdomain_enabled'] = true;
            if ($request->filled('subdomain')) {
                $validated['subdomain'] = \Illuminate\Support\Str::slug($request->subdomain);
            } else {
                $validated['subdomain'] = \Illuminate\Support\Str::slug($validated['name']);
            }
        } else {
            $validated['subdomain_enabled'] = false;
            $validated['subdomain'] = null;
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('contests', 'public');
        }

        $contest = Contest::create($validated);

        // Créer les candidats si fournis
        if ($request->has('candidates') && is_array($request->candidates)) {
            foreach ($request->candidates as $index => $candidateData) {
                if (!empty($candidateData['name'])) {
                    $candidateAttributes = [
                        'contest_id' => $contest->id,
                        'name' => $candidateData['name'],
                        'number' => $candidateData['number'] ?? ($index + 1),
                        'description' => $candidateData['description'] ?? null,
                        'is_active' => true,
                    ];

                    // Gérer l'upload de la photo
                    if ($request->hasFile("candidates.{$index}.photo")) {
                        $photoFile = $request->file("candidates.{$index}.photo");
                        if ($photoFile && $photoFile->isValid()) {
                            $candidateAttributes['photo'] = $photoFile->store('contest-candidates', 'public');
                        }
                    }

                    ContestCandidate::create($candidateAttributes);
                }
            }
        }

        $message = 'Concours créé avec succès.';
        if ($contest->candidates()->count() > 0) {
            $message .= ' ' . $contest->candidates()->count() . ' candidat(s) ajouté(s).';
        } else {
            $message .= ' Vous pouvez maintenant ajouter des candidats.';
        }

        return redirect()->route('contests.show', $contest)->with('success', $message);
    }

    public function edit(Contest $contest)
    {
        $this->authorize('update', $contest);
        
        $contest->load('candidates');
        $events = \App\Models\Event::where('organizer_id', auth()->id())->get();
        
        return view('contests.edit', compact('contest', 'events'));
    }

    public function update(Request $request, Contest $contest)
    {
        $this->authorize('update', $contest);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'rules' => 'nullable|string',
            'price_per_vote' => 'required|numeric|min:0',
            'points_per_vote' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'cover_image' => 'nullable|image|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'candidates' => 'nullable|array',
            'candidates.*.name' => 'required_with:candidates|string|max:255',
            'candidates.*.number' => 'required_with:candidates|integer|min:1',
            'candidates.*.description' => 'nullable|string',
            'candidates.*.photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($contest->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($contest->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('contests', 'public');
        }

        $contest->update($validated);

        // Créer les nouveaux candidats si fournis
        if ($request->has('candidates') && is_array($request->candidates)) {
            $newCandidatesCount = 0;
            foreach ($request->candidates as $index => $candidateData) {
                if (!empty($candidateData['name'])) {
                    $candidateAttributes = [
                        'contest_id' => $contest->id,
                        'name' => $candidateData['name'],
                        'number' => $candidateData['number'] ?? ($index + 1),
                        'description' => $candidateData['description'] ?? null,
                        'is_active' => true,
                    ];

                    // Gérer l'upload de la photo
                    if ($request->hasFile("candidates.{$index}.photo")) {
                        $photoFile = $request->file("candidates.{$index}.photo");
                        if ($photoFile && $photoFile->isValid()) {
                            $candidateAttributes['photo'] = $photoFile->store('contest-candidates', 'public');
                        }
                    }

                    ContestCandidate::create($candidateAttributes);
                    $newCandidatesCount++;
                }
            }

            $message = 'Concours mis à jour avec succès.';
            if ($newCandidatesCount > 0) {
                $message .= ' ' . $newCandidatesCount . ' nouveau(x) candidat(s) ajouté(s).';
            }

            return redirect()->route('organizer.contests.index')
                ->with('success', $message);
        }

        return redirect()->route('organizer.contests.index')
            ->with('success', 'Concours mis à jour avec succès.');
    }

    public function publish(Contest $contest)
    {
        $this->authorize('update', $contest);

        // Vérifier qu'il y a au moins un candidat
        if ($contest->candidates()->count() === 0) {
            return back()->with('error', 'Vous devez ajouter au moins un candidat avant de publier le concours.');
        }

        $contest->update(['is_published' => true]);

        return back()->with('success', 'Concours publié avec succès !');
    }
}

