<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'rules',
        'price_per_vote',
        'points_per_vote',
        'start_date',
        'end_date',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'price_per_vote' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function candidates()
    {
        return $this->hasMany(ContestCandidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function isActive(): bool
    {
        $now = now();
        return $this->is_active 
            && $now->gte($this->start_date)
            && $now->lte($this->end_date);
    }

    public function getTotalVotesAttribute()
    {
        return $this->votes()->sum('points');
    }

    public function getRanking()
    {
        return $this->candidates()
            ->withSum('votes', 'points')
            ->orderBy('votes_sum_points', 'desc')
            ->get();
    }
}

