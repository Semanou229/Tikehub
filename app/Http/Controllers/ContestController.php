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

        $contest->load(['candidates.votes', 'organizer']);
        $ranking = $contest->getRanking();

        return view('contests.show', compact('contest', 'ranking'));
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
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['is_published'] = false;
        $validated['is_active'] = true;

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('contests', 'public');
        }

        $contest = Contest::create($validated);

        return redirect()->route('contests.show', $contest)->with('success', 'Concours créé avec succès');
    }

    public function publish(Contest $contest)
    {
        $this->authorize('update', $contest);

        $contest->update(['is_published' => true]);

        return back()->with('success', 'Concours publié');
    }
}

