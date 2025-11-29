<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\User;
use App\Models\Event;
use App\Models\ContestCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContestController extends Controller
{
    public function index(Request $request)
    {
        $query = Contest::with('organizer');

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where('end_date', '>=', now());
            } elseif ($request->status === 'ended') {
                $query->where('end_date', '<', now());
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $contests = $query->withCount(['votes', 'candidates'])->latest()->paginate(20);

        return view('dashboard.admin.contests.index', compact('contests'));
    }

    public function show(Contest $contest)
    {
        $contest->load(['organizer', 'candidates', 'votes.user']);
        
        $stats = [
            'total_votes' => $contest->votes()->count(),
            'total_revenue' => $contest->votes()->sum('points') * $contest->vote_price,
            'unique_voters' => $contest->votes()->distinct('user_id')->count('user_id'),
        ];

        return view('dashboard.admin.contests.show', compact('contest', 'stats'));
    }

    public function create()
    {
        $organizers = User::role('organizer')->get();
        $events = Event::where('is_published', true)->get();
        return view('dashboard.admin.contests.create', compact('organizers', 'events'));
    }

    public function store(Request $request)
    {
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
            'organizer_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'candidates' => 'nullable|array',
            'candidates.*.name' => 'required_with:candidates|string|max:255',
            'candidates.*.number' => 'required_with:candidates|integer|min:1',
            'candidates.*.description' => 'nullable|string',
            'candidates.*.photo' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['price_per_vote'] = $validated['price_per_vote'];
        $validated['points_per_vote'] = $validated['points_per_vote'];
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : true;
        
        // Gestion du sous-domaine
        if ($request->has('subdomain_enabled') && $request->subdomain_enabled) {
            $validated['subdomain_enabled'] = true;
            if ($request->filled('subdomain')) {
                $validated['subdomain'] = Str::slug($request->subdomain);
            } else {
                $validated['subdomain'] = Str::slug($validated['name']);
            }
        } else {
            $validated['subdomain_enabled'] = false;
            $validated['subdomain'] = null;
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('contests', 'public');
        }

        $contest = Contest::create($validated);

        // Créer les candidats
        if ($request->has('candidates') && is_array($request->candidates)) {
            foreach ($request->candidates as $candidateData) {
                $candidate = new ContestCandidate([
                    'contest_id' => $contest->id,
                    'name' => $candidateData['name'],
                    'number' => $candidateData['number'],
                    'description' => $candidateData['description'] ?? null,
                    'points' => 0,
                ]);

                if (isset($candidateData['photo']) && $candidateData['photo']->isValid()) {
                    $candidate->photo = $candidateData['photo']->store('contest-candidates', 'public');
                }

                $candidate->save();
            }
        }

        return redirect()->route('admin.contests.show', $contest)
            ->with('success', 'Concours créé avec succès.');
    }

    public function edit(Contest $contest)
    {
        $organizers = User::role('organizer')->get();
        $events = Event::where('is_published', true)->get();
        $contest->load('candidates');
        return view('dashboard.admin.contests.edit', compact('contest', 'organizers', 'events'));
    }

    public function update(Request $request, Contest $contest)
    {
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
            'organizer_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'candidates' => 'nullable|array',
            'candidates.*.id' => 'nullable|exists:contest_candidates,id',
            'candidates.*.name' => 'required_with:candidates|string|max:255',
            'candidates.*.number' => 'required_with:candidates|integer|min:1',
            'candidates.*.description' => 'nullable|string',
            'candidates.*.photo' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['price_per_vote'] = $validated['price_per_vote'];
        $validated['points_per_vote'] = $validated['points_per_vote'];
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : $contest->is_active;
        
        // Gestion du sous-domaine
        if ($request->has('subdomain_enabled') && $request->subdomain_enabled) {
            $validated['subdomain_enabled'] = true;
            if ($request->filled('subdomain')) {
                $validated['subdomain'] = Str::slug($request->subdomain);
            } elseif (empty($contest->subdomain)) {
                $validated['subdomain'] = Str::slug($validated['name']);
            }
        } else {
            $validated['subdomain_enabled'] = false;
        }

        if ($request->hasFile('cover_image')) {
            if ($contest->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($contest->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('contests', 'public');
        }

        $contest->update($validated);

        // Gérer les candidats
        if ($request->has('candidates') && is_array($request->candidates)) {
            $existingIds = [];
            foreach ($request->candidates as $candidateData) {
                if (isset($candidateData['id'])) {
                    // Mettre à jour un candidat existant
                    $candidate = ContestCandidate::find($candidateData['id']);
                    if ($candidate && $candidate->contest_id === $contest->id) {
                        $candidate->name = $candidateData['name'];
                        $candidate->number = $candidateData['number'];
                        $candidate->description = $candidateData['description'] ?? null;
                        
                        if (isset($candidateData['photo']) && $candidateData['photo']->isValid()) {
                            if ($candidate->photo) {
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($candidate->photo);
                            }
                            $candidate->photo = $candidateData['photo']->store('contest-candidates', 'public');
                        }
                        
                        $candidate->save();
                        $existingIds[] = $candidate->id;
                    }
                } else {
                    // Créer un nouveau candidat
                    $candidate = new ContestCandidate([
                        'contest_id' => $contest->id,
                        'name' => $candidateData['name'],
                        'number' => $candidateData['number'],
                        'description' => $candidateData['description'] ?? null,
                        'points' => 0,
                    ]);

                    if (isset($candidateData['photo']) && $candidateData['photo']->isValid()) {
                        $candidate->photo = $candidateData['photo']->store('contest-candidates', 'public');
                    }

                    $candidate->save();
                    $existingIds[] = $candidate->id;
                }
            }
            
            // Supprimer les candidats qui ne sont plus dans la liste
            ContestCandidate::where('contest_id', $contest->id)
                ->whereNotIn('id', $existingIds)
                ->delete();
        }

        return redirect()->route('admin.contests.show', $contest)
            ->with('success', 'Concours mis à jour avec succès.');
    }
}

