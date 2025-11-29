<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\Automation;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();
        
        $automations = Automation::where('organizer_id', $organizerId)
            ->latest()
            ->paginate(20);

        $stats = [
            'total' => Automation::where('organizer_id', $organizerId)->count(),
            'active' => Automation::where('organizer_id', $organizerId)->where('is_active', true)->count(),
            'total_executed' => Automation::where('organizer_id', $organizerId)->sum('executed_count'),
        ];

        return view('dashboard.organizer.crm.automations.index', compact('automations', 'stats'));
    }

    public function create()
    {
        $triggers = [
            'ticket_purchased' => 'Achat de billet',
            'cart_abandoned' => 'Panier abandonné',
            'before_event' => 'Avant l\'événement',
            'after_event' => 'Après l\'événement',
            'vote_cast' => 'Vote effectué',
            'donation_made' => 'Don effectué',
            'custom' => 'Personnalisé',
        ];

        $actions = [
            'send_email' => 'Envoyer un email',
            'add_tag' => 'Ajouter une étiquette',
            'assign_to' => 'Assigner à un membre',
            'update_stage' => 'Mettre à jour le pipeline',
            'create_task' => 'Créer une tâche',
        ];

        return view('dashboard.organizer.crm.automations.create', compact('triggers', 'actions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'trigger_type' => 'required|in:ticket_purchased,cart_abandoned,before_event,after_event,vote_cast,donation_made,custom',
            'trigger_conditions' => 'nullable|array',
            'action_type' => 'required|in:send_email,add_tag,assign_to,update_stage,create_task',
            'action_config' => 'required|array',
            'delay_minutes' => 'nullable|integer|min:0',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');

        $automation = Automation::create($validated);

        return redirect()->route('organizer.crm.automations.index')
            ->with('success', 'Automation créée avec succès.');
    }

    public function edit(Automation $automation)
    {
        $this->authorize('update', $automation);

        $triggers = [
            'ticket_purchased' => 'Achat de billet',
            'cart_abandoned' => 'Panier abandonné',
            'before_event' => 'Avant l\'événement',
            'after_event' => 'Après l\'événement',
            'vote_cast' => 'Vote effectué',
            'donation_made' => 'Don effectué',
            'custom' => 'Personnalisé',
        ];

        $actions = [
            'send_email' => 'Envoyer un email',
            'add_tag' => 'Ajouter une étiquette',
            'assign_to' => 'Assigner à un membre',
            'update_stage' => 'Mettre à jour le pipeline',
            'create_task' => 'Créer une tâche',
        ];

        return view('dashboard.organizer.crm.automations.edit', compact('automation', 'triggers', 'actions'));
    }

    public function update(Request $request, Automation $automation)
    {
        $this->authorize('update', $automation);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'trigger_type' => 'required|in:ticket_purchased,cart_abandoned,before_event,after_event,vote_cast,donation_made,custom',
            'trigger_conditions' => 'nullable|array',
            'action_type' => 'required|in:send_email,add_tag,assign_to,update_stage,create_task',
            'action_config' => 'required|array',
            'delay_minutes' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $automation->update($validated);

        return redirect()->route('organizer.crm.automations.index')
            ->with('success', 'Automation mise à jour avec succès.');
    }

    public function destroy(Automation $automation)
    {
        $this->authorize('delete', $automation);

        $automation->delete();

        return redirect()->route('organizer.crm.automations.index')
            ->with('success', 'Automation supprimée avec succès.');
    }

    public function toggle(Request $request, Automation $automation)
    {
        $this->authorize('update', $automation);

        $automation->update(['is_active' => !$automation->is_active]);

        return back()->with('success', 'Automation ' . ($automation->is_active ? 'activée' : 'désactivée') . ' avec succès.');
    }
}
