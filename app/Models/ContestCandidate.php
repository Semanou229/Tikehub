<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestCandidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'contest_id',
        'name',
        'description',
        'photo',
        'number',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'candidate_id');
    }

    public function getTotalPointsAttribute()
    {
        return $this->votes()->sum('points');
    }
}


