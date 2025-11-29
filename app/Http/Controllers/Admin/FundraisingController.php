<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function create()
    {
        $organizers = User::role('organizer')->get();
        $events = Event::where('is_published', true)->get();
        return view('dashboard.admin.fundraisings.create', compact('organizers', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'show_donors' => 'nullable|boolean',
            'cover_image' => 'nullable|image|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'organizer_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['current_amount'] = 0;
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : true;
        $validated['show_donors'] = $request->has('show_donors');
        
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
            $validated['cover_image'] = $request->file('cover_image')->store('fundraisings', 'public');
        }

        $fundraising = Fundraising::create($validated);

        return redirect()->route('admin.fundraisings.show', $fundraising)
            ->with('success', 'Collecte de fonds créée avec succès.');
    }

    public function edit(Fundraising $fundraising)
    {
        $organizers = User::role('organizer')->get();
        $events = Event::where('is_published', true)->get();
        return view('dashboard.admin.fundraisings.edit', compact('fundraising', 'organizers', 'events'));
    }

    public function update(Request $request, Fundraising $fundraising)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'show_donors' => 'nullable|boolean',
            'cover_image' => 'nullable|image|max:2048',
            'event_id' => 'nullable|exists:events,id',
            'organizer_id' => 'required|exists:users,id',
            'is_published' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : $fundraising->is_active;
        $validated['show_donors'] = $request->has('show_donors');
        
        // Gestion du sous-domaine
        if ($request->has('subdomain_enabled') && $request->subdomain_enabled) {
            $validated['subdomain_enabled'] = true;
            if ($request->filled('subdomain')) {
                $validated['subdomain'] = Str::slug($request->subdomain);
            } elseif (empty($fundraising->subdomain)) {
                $validated['subdomain'] = Str::slug($validated['name']);
            }
        } else {
            $validated['subdomain_enabled'] = false;
        }

        if ($request->hasFile('cover_image')) {
            if ($fundraising->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($fundraising->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('fundraisings', 'public');
        }

        $fundraising->update($validated);

        return redirect()->route('admin.fundraisings.show', $fundraising)
            ->with('success', 'Collecte de fonds mise à jour avec succès.');
    }
}

