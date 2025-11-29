<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Tag;
use App\Models\Segment;
use App\Models\Ticket;
use App\Models\Vote;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactsImport;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = auth()->id();
        
        $query = Contact::where('organizer_id', $organizerId)
            ->with(['tags', 'assignedUser', 'segments']);

        // Filtres
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('pipeline_stage')) {
            $query->where('pipeline_stage', $request->pipeline_stage);
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $contacts = $query->latest()->paginate(20);
        $tags = Tag::where('organizer_id', $organizerId)->get();
        $segments = Segment::where('organizer_id', $organizerId)->where('is_active', true)->get();

        // Statistiques
        $stats = [
            'total' => Contact::where('organizer_id', $organizerId)->count(),
            'by_category' => Contact::where('organizer_id', $organizerId)
                ->select('category', DB::raw('count(*) as count'))
                ->groupBy('category')
                ->pluck('count', 'category'),
            'by_stage' => Contact::where('organizer_id', $organizerId)
                ->select('pipeline_stage', DB::raw('count(*) as count'))
                ->groupBy('pipeline_stage')
                ->pluck('count', 'pipeline_stage'),
        ];

        return view('dashboard.organizer.crm.contacts.index', compact('contacts', 'tags', 'segments', 'stats'));
    }

    public function create()
    {
        $organizerId = auth()->id();
        $tags = Tag::where('organizer_id', $organizerId)->get();
        $teamMembers = \App\Models\User::where('team_id', function ($q) use ($organizerId) {
            $q->select('id')->from('teams')->where('organizer_id', $organizerId);
        })->orWhere('id', $organizerId)->get();

        return view('dashboard.organizer.crm.contacts.create', compact('tags', 'teamMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'category' => 'required|in:participant,sponsor,staff,press,vip,partner,prospect,other',
            'pipeline_stage' => 'required|in:prospect,confirmed,partner,closed',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $validated['organizer_id'] = auth()->id();
        $contact = Contact::create($validated);

        if ($request->has('tags')) {
            $contact->tags()->sync($request->tags);
        }

        // Log activité
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'organizer_id' => auth()->id(),
            'action' => 'created_contact',
            'model_type' => Contact::class,
            'model_id' => $contact->id,
            'description' => "Contact créé: {$contact->full_name}",
        ]);

        return redirect()->route('organizer.crm.contacts.index')
            ->with('success', 'Contact créé avec succès.');
    }

    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        $contact->load(['tags', 'segments', 'assignedUser', 'tickets.event', 'votes.contest', 'donations.fundraising']);

        // Historique des interactions
        $activities = \App\Models\ActivityLog::where('organizer_id', auth()->id())
            ->where(function ($q) use ($contact) {
                $q->where('model_type', Contact::class)
                  ->where('model_id', $contact->id)
                  ->orWhere(function ($query) use ($contact) {
                      $query->where('model_type', Ticket::class)
                            ->whereIn('model_id', $contact->tickets->pluck('id'));
                  });
            })
            ->latest()
            ->take(20)
            ->get();

        return view('dashboard.organizer.crm.contacts.show', compact('contact', 'activities'));
    }

    public function edit(Contact $contact)
    {
        $this->authorize('update', $contact);

        $organizerId = auth()->id();
        $tags = Tag::where('organizer_id', $organizerId)->get();
        $teamMembers = \App\Models\User::where('team_id', function ($q) use ($organizerId) {
            $q->select('id')->from('teams')->where('organizer_id', $organizerId);
        })->orWhere('id', $organizerId)->get();

        $contact->load('tags');

        return view('dashboard.organizer.crm.contacts.edit', compact('contact', 'tags', 'teamMembers'));
    }

    public function update(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'category' => 'required|in:participant,sponsor,staff,press,vip,partner,prospect,other',
            'pipeline_stage' => 'required|in:prospect,confirmed,partner,closed',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $contact->update($validated);

        if ($request->has('tags')) {
            $contact->tags()->sync($request->tags);
        }

        return redirect()->route('organizer.crm.contacts.show', $contact)
            ->with('success', 'Contact mis à jour avec succès.');
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();

        return redirect()->route('organizer.crm.contacts.index')
            ->with('success', 'Contact supprimé avec succès.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls|max:5120',
        ]);

        try {
            Excel::import(new ContactsImport(auth()->id()), $request->file('file'));

            return back()->with('success', 'Contacts importés avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    public function assign(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $contact->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Contact assigné avec succès.');
    }
}
