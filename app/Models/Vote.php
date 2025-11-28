<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'contest_id',
        'candidate_id',
        'user_id',
        'payment_id',
        'points',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function candidate()
    {
        return $this->belongsTo(ContestCandidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}

