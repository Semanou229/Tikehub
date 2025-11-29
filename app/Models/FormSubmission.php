<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'contact_id',
        'submitter_name',
        'submitter_email',
        'submitter_phone',
        'form_data',
        'files',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'files' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(CustomForm::class, 'form_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
