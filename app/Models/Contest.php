<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'subdomain',
        'subdomain_enabled',
        'event_id',
        'organizer_id',
        'name',
        'cover_image',
        'description',
        'rules',
        'price_per_vote',
        'points_per_vote',
        'start_date',
        'end_date',
        'is_active',
        'is_published',
        'settings',
    ];

    protected $casts = [
        'price_per_vote' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'subdomain_enabled' => 'boolean',
        'settings' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contest) {
            if (empty($contest->slug)) {
                $contest->slug = \Illuminate\Support\Str::slug($contest->name);
            }
            if (empty($contest->subdomain) && $contest->subdomain_enabled) {
                $contest->subdomain = \Illuminate\Support\Str::slug($contest->name);
            }
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
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

