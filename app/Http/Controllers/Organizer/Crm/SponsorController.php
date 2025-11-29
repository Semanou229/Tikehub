<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\Event;
use App\Models\Contact;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();
        
        $sponsors = Sponsor::where('organizer_id', $organizerId)
            ->with(['event', 'contact'])
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Sponsor::where('organizer_id', $organizerId)->count(),
            'total_contribution' => Sponsor::where('organizer_id', $organizerId)->sum('contribution_amount'),
            'by_status' => Sponsor::where('organizer_id', $organizerId)
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
        ];

        return view('dashboard.organizer.crm.sponsors.index', compact('sponsors', 'stats'));
    }

    public function create()
    {
        $organizerId = auth()->id();
        $events = Event::where('organizer_id', $organizerId)->get();
        $contacts = Contact::where('organizer_id', $organizerId)->where('category', 'sponsor')->get();

        return view('dashboard.organizer.crm.sponsors.create', compact('events', 'contacts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'sponsor_type' => 'required|in:gold,silver,bronze,partner,media,other',
            'contribution_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'benefits' => 'nullable|string',
            'deliverables' => 'nullable|array',
            'status' => 'required|in:prospect,negotiating,confirmed,delivered,closed',
            'event_id' => 'nullable|exists:events,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['organizer_id'] = auth()->id();
        $sponsor = Sponsor::create($validated);

        return redirect()->route('organizer.crm.sponsors.show', $sponsor)
            ->with('success', 'Sponsor créé avec succès.');
    }

    public function show(Sponsor $sponsor)
    {
        $this->authorize('view', $sponsor);

        $sponsor->load(['event', 'contact']);

        return view('dashboard.organizer.crm.sponsors.show', compact('sponsor'));
    }

    public function edit(Sponsor $sponsor)
    {
        $this->authorize('update', $sponsor);

        $organizerId = auth()->id();
        $events = Event::where('organizer_id', $organizerId)->get();
        $contacts = Contact::where('organizer_id', $organizerId)->where('category', 'sponsor')->get();

        return view('dashboard.organizer.crm.sponsors.edit', compact('sponsor', 'events', 'contacts'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $this->authorize('update', $sponsor);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'sponsor_type' => 'required|in:gold,silver,bronze,partner,media,other',
            'contribution_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'benefits' => 'nullable|string',
            'deliverables' => 'nullable|array',
            'status' => 'required|in:prospect,negotiating,confirmed,delivered,closed',
            'event_id' => 'nullable|exists:events,id',
            'contact_id' => 'nullable|exists:contacts,id',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $sponsor->update($validated);

        return redirect()->route('organizer.crm.sponsors.show', $sponsor)
            ->with('success', 'Sponsor mis à jour avec succès.');
    }

    public function destroy(Sponsor $sponsor)
    {
        $this->authorize('delete', $sponsor);

        $sponsor->delete();

        return redirect()->route('organizer.crm.sponsors.index')
            ->with('success', 'Sponsor supprimé avec succès.');
    }
}
