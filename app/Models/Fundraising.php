<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fundraising extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'goal_amount',
        'current_amount',
        'start_date',
        'end_date',
        'show_donors',
        'is_active',
        'milestones',
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'show_donors' => 'boolean',
        'is_active' => 'boolean',
        'milestones' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->goal_amount == 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->goal_amount) * 100);
    }
}

