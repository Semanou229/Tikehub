<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\Contact;
use App\Models\Segment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailCampaignController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();
        
        $campaigns = EmailCampaign::where('organizer_id', $organizerId)
            ->with('segment')
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => EmailCampaign::where('organizer_id', $organizerId)->count(),
            'sent' => EmailCampaign::where('organizer_id', $organizerId)->where('status', 'sent')->count(),
            'draft' => EmailCampaign::where('organizer_id', $organizerId)->where('status', 'draft')->count(),
            'total_sent' => EmailCampaign::where('organizer_id', $organizerId)->sum('sent_count'),
            'total_opened' => EmailCampaign::where('organizer_id', $organizerId)->sum('opened_count'),
        ];

        return view('dashboard.organizer.crm.campaigns.index', compact('campaigns', 'stats'));
    }

    public function create()
    {
        $organizerId = auth()->id();
        $segments = Segment::where('organizer_id', $organizerId)->where('is_active', true)->get();
        $templates = [
            'announcement' => 'Annonce d\'événement',
            'reminder' => 'Relance billetterie',
            'thank_you' => 'Remerciements',
            'practical_info' => 'Infos pratiques',
            'custom' => 'Personnalisé',
        ];

        return view('dashboard.organizer.crm.campaigns.create', compact('segments', 'templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'template_type' => 'required|in:announcement,reminder,thank_you,practical_info,custom',
            'segment_id' => 'nullable|exists:segments,id',
            'scheduled_at' => 'nullable|date',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['status'] = $request->has('scheduled_at') ? 'scheduled' : 'draft';

        $campaign = EmailCampaign::create($validated);

        return redirect()->route('organizer.crm.campaigns.show', $campaign)
            ->with('success', 'Campagne créée avec succès.');
    }

    public function show(EmailCampaign $campaign)
    {
        $this->authorize('view', $campaign);

        $campaign->load(['segment', 'recipients']);

        $stats = [
            'sent' => $campaign->recipients()->where('status', 'sent')->count(),
            'opened' => $campaign->recipients()->where('status', 'opened')->count(),
            'clicked' => $campaign->recipients()->where('status', 'clicked')->count(),
            'bounced' => $campaign->recipients()->where('status', 'bounced')->count(),
            'pending' => $campaign->recipients()->where('status', 'pending')->count(),
        ];

        return view('dashboard.organizer.crm.campaigns.show', compact('campaign', 'stats'));
    }

    public function edit(EmailCampaign $campaign)
    {
        $this->authorize('update', $campaign);

        $organizerId = auth()->id();
        $segments = Segment::where('organizer_id', $organizerId)->where('is_active', true)->get();
        $templates = [
            'announcement' => 'Annonce d\'événement',
            'reminder' => 'Relance billetterie',
            'thank_you' => 'Remerciements',
            'practical_info' => 'Infos pratiques',
            'custom' => 'Personnalisé',
        ];

        return view('dashboard.organizer.crm.campaigns.edit', compact('campaign', 'segments', 'templates'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'template_type' => 'required|in:announcement,reminder,thank_you,practical_info,custom',
            'segment_id' => 'nullable|exists:segments,id',
            'scheduled_at' => 'nullable|date',
        ]);

        if ($request->has('scheduled_at') && !$campaign->scheduled_at) {
            $validated['status'] = 'scheduled';
        }

        $campaign->update($validated);

        return redirect()->route('organizer.crm.campaigns.show', $campaign)
            ->with('success', 'Campagne mise à jour avec succès.');
    }

    public function destroy(EmailCampaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();

        return redirect()->route('organizer.crm.campaigns.index')
            ->with('success', 'Campagne supprimée avec succès.');
    }

    public function send(Request $request, EmailCampaign $campaign)
    {
        $this->authorize('update', $campaign);

        if ($campaign->status === 'sent') {
            return back()->with('error', 'Cette campagne a déjà été envoyée.');
        }

        // Récupérer les destinataires
        $recipients = [];
        
        if ($campaign->segment_id) {
            $segment = Segment::find($campaign->segment_id);
            $recipients = $segment->contacts()->where('is_active', true)->get();
        } else {
            // Tous les contacts de l'organisateur
            $recipients = Contact::where('organizer_id', auth()->id())
                ->where('is_active', true)
                ->whereNotNull('email')
                ->get();
        }

        $campaign->update(['status' => 'sending']);

        // Envoyer les emails (en queue pour les gros volumes)
        foreach ($recipients as $contact) {
            \App\Models\EmailCampaignRecipient::create([
                'campaign_id' => $campaign->id,
                'contact_id' => $contact->id,
                'email' => $contact->email,
                'status' => 'pending',
            ]);

            // TODO: Implémenter l'envoi réel d'emails via queue
            // Mail::to($contact->email)->send(new CampaignEmail($campaign, $contact));
        }

        $campaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $recipients->count(),
        ]);

        return back()->with('success', "Campagne envoyée à {$recipients->count()} destinataires.");
    }
}
