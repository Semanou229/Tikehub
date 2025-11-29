<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'event_id',
        'contact_id',
        'name',
        'company',
        'email',
        'phone',
        'sponsor_type',
        'contribution_amount',
        'currency',
        'benefits',
        'deliverables',
        'status',
        'contract_start_date',
        'contract_end_date',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'contribution_amount' => 'decimal:2',
        'deliverables' => 'array',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
