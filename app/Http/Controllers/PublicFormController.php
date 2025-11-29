<?php

namespace App\Http\Controllers;

use App\Models\CustomForm;
use App\Models\FormSubmission;
use App\Models\Contact;
use Illuminate\Http\Request;

class PublicFormController extends Controller
{
    public function show($slug)
    {
        $form = CustomForm::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('forms.public.show', compact('form'));
    }

    public function submit(Request $request, $slug)
    {
        $form = CustomForm::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Validation dynamique basée sur les champs du formulaire
        $rules = [];
        foreach ($form->fields as $index => $field) {
            $fieldName = 'field_' . $index;
            $rules[$fieldName] = [];
            
            if (isset($field['required']) && $field['required']) {
                $rules[$fieldName][] = 'required';
            } else {
                $rules[$fieldName][] = 'nullable';
            }

            // Validation selon le type
            switch ($field['type']) {
                case 'email':
                    $rules[$fieldName][] = 'email';
                    break;
                case 'phone':
                    $rules[$fieldName][] = 'string';
                    break;
                case 'file':
                    $rules[$fieldName][] = 'file';
                    break;
                default:
                    $rules[$fieldName][] = 'string';
            }
        }

        $validated = $request->validate($rules);

        // Préparer les données du formulaire
        $formData = [];
        $files = [];
        
        foreach ($form->fields as $index => $field) {
            $fieldName = 'field_' . $index;
            $value = $validated[$fieldName] ?? null;
            
            if ($field['type'] === 'file' && $request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $path = $file->store('form-submissions', 'public');
                $files[$field['label']] = $path;
                $formData[$field['label']] = $file->getClientOriginalName();
            } else {
                $formData[$field['label']] = $value;
            }
        }

        // Créer la soumission
        $submission = FormSubmission::create([
            'form_id' => $form->id,
            'submitter_name' => $request->input('submitter_name'),
            'submitter_email' => $request->input('submitter_email'),
            'submitter_phone' => $request->input('submitter_phone'),
            'form_data' => $formData,
            'files' => !empty($files) ? $files : null,
            'status' => $form->requires_approval ? 'pending' : 'approved',
        ]);

        // Si pas d'approbation requise, créer automatiquement un contact
        if (!$form->requires_approval && $request->input('submitter_email')) {
            $contact = Contact::firstOrCreate(
                [
                    'organizer_id' => $form->organizer_id,
                    'email' => $request->input('submitter_email'),
                ],
                [
                    'first_name' => explode(' ', $request->input('submitter_name', ''))[0] ?? '',
                    'last_name' => implode(' ', array_slice(explode(' ', $request->input('submitter_name', '')), 1)) ?? '',
                    'phone' => $request->input('submitter_phone'),
                    'category' => $form->form_type === 'vip' ? 'vip' : 'participant',
                    'pipeline_stage' => 'confirmed',
                ]
            );

            $submission->update(['contact_id' => $contact->id]);
        }

        // Mettre à jour le compteur
        $form->increment('submissions_count');

        return redirect()->route('forms.show', $form->slug)
            ->with('success', 'Votre formulaire a été soumis avec succès !' . ($form->requires_approval ? ' Il sera examiné sous peu.' : ''));
    }
}
