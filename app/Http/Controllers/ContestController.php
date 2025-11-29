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

        $contests = $query->withCount('votes')
            ->orderBy('votes_count', 'desc')
            ->paginate(12);

        return view('contests.index', compact('contests'));
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

        $contest->load(['organizer']);

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

            // Récupérer l'URL de paiement depuis la réponse Moneroo
            $monerooService = app(\App\Services\MonerooService::class);
            $monerooPayment = $monerooService->getPaymentStatus($payment->moneroo_transaction_id);
            
            if (isset($monerooPayment['payment_url'])) {
                return redirect($monerooPayment['payment_url']);
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

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('contests', 'public');
        }

        $contest = Contest::create($validated);

        // Créer les candidats si fournis
        if ($request->has('candidates') && is_array($request->candidates)) {
            foreach ($request->candidates as $candidateData) {
                if (!empty($candidateData['name'])) {
                    $candidateAttributes = [
                        'contest_id' => $contest->id,
                        'name' => $candidateData['name'],
                        'number' => $candidateData['number'] ?? 1,
                        'description' => $candidateData['description'] ?? null,
                        'is_active' => true,
                    ];

                    // Gérer l'upload de la photo
                    if (isset($candidateData['photo']) && $request->hasFile("candidates.{$candidateData['number']}.photo")) {
                        $photoFile = $request->file("candidates.{$candidateData['number']}.photo");
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

    public function publish(Contest $contest)
    {
        $this->authorize('update', $contest);

        $contest->update(['is_published' => true]);

        return back()->with('success', 'Concours publié');
    }
}

