<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class FundraisingController extends Controller
{
    public function index(Request $request)
    {
        $query = Fundraising::with('organizer');

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

        $fundraisings = $query->latest()->paginate(20);

        return view('dashboard.admin.fundraisings.index', compact('fundraisings'));
    }

    public function show(Fundraising $fundraising)
    {
        $fundraising->load(['organizer', 'donations.user']);
        
        $stats = [
            'total_donations' => $fundraising->donations()->count(),
            'total_amount' => $fundraising->current_amount,
            'unique_donors' => $fundraising->donations()->distinct('user_id')->count('user_id'),
            'progress' => $fundraising->goal_amount > 0 ? ($fundraising->current_amount / $fundraising->goal_amount) * 100 : 0,
        ];

        return view('dashboard.admin.fundraisings.show', compact('fundraising', 'stats'));
    }
}

