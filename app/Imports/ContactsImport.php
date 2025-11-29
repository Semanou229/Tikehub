<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\Tag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ContactsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $organizerId;

    public function __construct($organizerId)
    {
        $this->organizerId = $organizerId;
    }

    public function model(array $row)
    {
        return new Contact([
            'organizer_id' => $this->organizerId,
            'first_name' => $row['prenom'] ?? $row['first_name'] ?? $row['nom'] ?? '',
            'last_name' => $row['nom'] ?? $row['last_name'] ?? $row['name'] ?? '',
            'email' => $row['email'] ?? null,
            'phone' => $row['telephone'] ?? $row['phone'] ?? null,
            'company' => $row['entreprise'] ?? $row['company'] ?? null,
            'job_title' => $row['poste'] ?? $row['job_title'] ?? null,
            'category' => $row['categorie'] ?? $row['category'] ?? 'participant',
            'pipeline_stage' => 'prospect',
            'is_active' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'prenom' => 'nullable',
            'first_name' => 'nullable',
            'nom' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable|email',
        ];
    }
}

