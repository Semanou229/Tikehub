<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'job_title',
        'category',
        'pipeline_stage',
        'assigned_to',
        'notes',
        'custom_fields',
        'metadata',
        'last_contacted_at',
        'next_follow_up_at',
        'is_active',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'metadata' => 'array',
        'last_contacted_at' => 'datetime',
        'next_follow_up_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function segments()
    {
        return $this->belongsToMany(Segment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'buyer_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'user_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'user_id');
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public function formSubmissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getTotalSpentAttribute()
    {
        return $this->tickets()->where('status', 'paid')->sum('price') +
               $this->votes()->sum('points') +
               $this->donations()->sum('amount');
    }
}
