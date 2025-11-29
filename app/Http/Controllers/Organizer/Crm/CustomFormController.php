<?php

namespace App\Http\Controllers\Organizer\Crm;

use App\Http\Controllers\Controller;
use App\Models\CustomForm;
use App\Models\FormSubmission;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Exports\FormSubmissionsExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomFormController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();
        
        $forms = CustomForm::where('organizer_id', $organizerId)
            ->with('event')
            ->latest()
            ->paginate(20);

        return view('dashboard.organizer.crm.forms.index', compact('forms'));
    }

    public function create()
    {
        $organizerId = auth()->id();
        $events = Event::where('organizer_id', $organizerId)->get();

        return view('dashboard.organizer.crm.forms.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'form_type' => 'required|in:press,exhibitor,volunteer,vip,custom',
            'event_id' => 'nullable|exists:events,id',
            'fields' => 'required|array|min:1',
            'fields.*.type' => 'required|in:text,email,phone,textarea,select,checkbox,file',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.required' => 'boolean',
            'requires_approval' => 'boolean',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');

        $form = CustomForm::create($validated);

        return redirect()->route('organizer.crm.forms.show', $form)
            ->with('success', 'Formulaire créé avec succès.');
    }

    public function show(CustomForm $form)
    {
        $this->authorize('view', $form);

        $form->load(['event', 'submissions.contact']);

        $stats = [
            'total_submissions' => $form->submissions()->count(),
            'pending' => $form->submissions()->where('status', 'pending')->count(),
            'approved' => $form->submissions()->where('status', 'approved')->count(),
            'rejected' => $form->submissions()->where('status', 'rejected')->count(),
        ];

        return view('dashboard.organizer.crm.forms.show', compact('form', 'stats'));
    }

    public function edit(CustomForm $form)
    {
        $this->authorize('update', $form);

        $organizerId = auth()->id();
        $events = Event::where('organizer_id', $organizerId)->get();

        return view('dashboard.organizer.crm.forms.edit', compact('form', 'events'));
    }

    public function update(Request $request, CustomForm $form)
    {
        $this->authorize('update', $form);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'form_type' => 'required|in:press,exhibitor,volunteer,vip,custom',
            'event_id' => 'nullable|exists:events,id',
            'fields' => 'required|array|min:1',
            'fields.*.type' => 'required|in:text,email,phone,textarea,select,checkbox,file',
            'fields.*.label' => 'required|string|max:255',
            'fields.*.required' => 'boolean',
            'requires_approval' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $form->update($validated);

        return redirect()->route('organizer.crm.forms.show', $form)
            ->with('success', 'Formulaire mis à jour avec succès.');
    }

    public function destroy(CustomForm $form)
    {
        $this->authorize('delete', $form);

        $form->delete();

        return redirect()->route('organizer.crm.forms.index')
            ->with('success', 'Formulaire supprimé avec succès.');
    }

    public function submissions(CustomForm $form)
    {
        $this->authorize('view', $form);

        $submissions = $form->submissions()
            ->with('contact')
            ->latest()
            ->paginate(20);

        return view('dashboard.organizer.crm.forms.submissions', compact('form', 'submissions'));
    }

    public function showSubmission(CustomForm $form, FormSubmission $submission)
    {
        $this->authorize('view', $form);

        return response()->json([
            'submitter_name' => $submission->submitter_name,
            'submitter_email' => $submission->submitter_email,
            'submitter_phone' => $submission->submitter_phone,
            'form_data' => $submission->form_data,
            'admin_notes' => $submission->admin_notes,
        ]);
    }

    public function approveSubmission(Request $request, CustomForm $form, FormSubmission $submission)
    {
        $this->authorize('update', $form);

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $submission->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Créer un contact si approuvé et n'existe pas
        if ($request->status === 'approved' && !$submission->contact_id) {
            $contact = \App\Models\Contact::create([
                'organizer_id' => auth()->id(),
                'first_name' => $submission->submitter_name ?? 'N/A',
                'last_name' => '',
                'email' => $submission->submitter_email,
                'phone' => $submission->submitter_phone,
                'category' => $form->form_type === 'vip' ? 'vip' : 'participant',
                'pipeline_stage' => 'confirmed',
            ]);

            $submission->update(['contact_id' => $contact->id]);
        }

        return back()->with('success', 'Soumission ' . ($request->status === 'approved' ? 'approuvée' : 'rejetée') . ' avec succès.');
    }

    public function export(CustomForm $form, Request $request)
    {
        $this->authorize('view', $form);

        $format = $request->get('format', 'xlsx'); // xlsx ou csv

        $fileName = 'soumissions_' . str_replace(' ', '_', $form->name) . '_' . now()->format('Y-m-d_His') . '.' . $format;

        return Excel::download(new FormSubmissionsExport($form), $fileName);
    }
}
