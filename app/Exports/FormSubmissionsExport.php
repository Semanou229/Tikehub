<?php

namespace App\Exports;

use App\Models\CustomForm;
use App\Models\FormSubmission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FormSubmissionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $form;
    protected $submissions;

    public function __construct(CustomForm $form)
    {
        $this->form = $form;
        $this->submissions = $form->submissions()->with('reviewer')->get();
    }

    public function collection()
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        $headings = [
            'ID',
            'Date de soumission',
            'Nom',
            'Email',
            'Téléphone',
            'Statut',
            'Date de révision',
            'Révisé par',
            'Notes admin',
        ];

        // Ajouter les colonnes pour chaque champ du formulaire
        if ($this->form->fields && is_array($this->form->fields)) {
            foreach ($this->form->fields as $field) {
                $headings[] = $field['label'] ?? 'Champ';
            }
        }

        return $headings;
    }

    public function map($submission): array
    {
        $row = [
            $submission->id,
            $submission->created_at->translatedFormat('d/m/Y H:i:s'),
            $submission->submitter_name ?? 'N/A',
            $submission->submitter_email ?? 'N/A',
            $submission->submitter_phone ?? 'N/A',
            $this->getStatusLabel($submission->status),
            $submission->reviewed_at ? $submission->reviewed_at->translatedFormat('d/m/Y H:i:s') : 'N/A',
            $submission->reviewer->name ?? 'N/A',
            $submission->admin_notes ?? '',
        ];

        // Ajouter les valeurs des champs du formulaire
        if ($this->form->fields && is_array($this->form->fields)) {
            $formData = $submission->form_data ?? [];
            foreach ($this->form->fields as $field) {
                $fieldKey = $field['name'] ?? strtolower(str_replace(' ', '_', $field['label'] ?? ''));
                $value = $formData[$fieldKey] ?? '';
                
                // Gérer les valeurs multiples (checkboxes, select multiple)
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                
                $row[] = $value;
            }
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        $widths = [
            'A' => 10,  // ID
            'B' => 20,  // Date de soumission
            'C' => 25,  // Nom
            'D' => 30,  // Email
            'E' => 20,  // Téléphone
            'F' => 15,  // Statut
            'G' => 20,  // Date de révision
            'H' => 25,  // Révisé par
            'I' => 30,  // Notes admin
        ];

        // Ajuster la largeur pour les colonnes des champs
        $startColumn = 'J';
        if ($this->form->fields && is_array($this->form->fields)) {
            foreach ($this->form->fields as $index => $field) {
                $column = $this->getColumnLetter(9 + $index + 1); // Commencer à J (colonne 10)
                $widths[$column] = 25;
            }
        }

        return $widths;
    }

    protected function getStatusLabel($status): string
    {
        return match($status) {
            'pending' => 'En attente',
            'approved' => 'Approuvé',
            'rejected' => 'Rejeté',
            default => ucfirst($status),
        };
    }

    protected function getColumnLetter($number): string
    {
        $letter = '';
        while ($number > 0) {
            $number--;
            $letter = chr(65 + ($number % 26)) . $letter;
            $number = intval($number / 26);
        }
        return $letter;
    }
}

