<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();

        // Récupérer les contacts groupés par stage
        $stages = ['prospect', 'confirmed', 'partner', 'closed'];
        $contactsByStage = [];

        foreach ($stages as $stage) {
            $contactsByStage[$stage] = Contact::where('organizer_id', $organizerId)
                ->where('pipeline_stage', $stage)
                ->with(['tags', 'assignedUser'])
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        // Statistiques
        $stats = [
            'total' => Contact::where('organizer_id', $organizerId)->count(),
            'prospect' => Contact::where('organizer_id', $organizerId)->where('pipeline_stage', 'prospect')->count(),
            'confirmed' => Contact::where('organizer_id', $organizerId)->where('pipeline_stage', 'confirmed')->count(),
            'partner' => Contact::where('organizer_id', $organizerId)->where('pipeline_stage', 'partner')->count(),
            'closed' => Contact::where('organizer_id', $organizerId)->where('pipeline_stage', 'closed')->count(),
        ];

        return view('dashboard.organizer.crm.pipeline.index', compact('contactsByStage', 'stats'));
    }

    public function updateStage(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $request->validate([
            'pipeline_stage' => 'required|in:prospect,confirmed,partner,closed',
        ]);

        $contact->update(['pipeline_stage' => $request->pipeline_stage]);

        // Log activité
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'organizer_id' => auth()->id(),
            'action' => 'updated_pipeline_stage',
            'model_type' => Contact::class,
            'model_id' => $contact->id,
            'description' => "Pipeline mis à jour: {$request->pipeline_stage}",
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stage mis à jour avec succès.',
        ]);
    }
}
