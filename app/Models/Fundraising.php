<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundraising extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'organizer_id',
        'name',
        'slug',
        'cover_image',
        'description',
        'goal_amount',
        'current_amount',
        'start_date',
        'end_date',
        'show_donors',
        'is_active',
        'is_published',
        'milestones',
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'show_donors' => 'boolean',
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'milestones' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function isActive(): bool
    {
        $now = now();
        return $this->is_active 
            && $now->gte($this->start_date)
            && $now->lte($this->end_date);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->goal_amount == 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->goal_amount) * 100);
    }
}

