<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;

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
}

