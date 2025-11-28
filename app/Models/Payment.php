<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'paymentable_type',
        'paymentable_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'moneroo_transaction_id',
        'moneroo_reference',
        'platform_commission',
        'organizer_amount',
        'metadata',
        'refunded_at',
        'refund_amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'organizer_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'refunded_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function donation()
    {
        return $this->hasOne(Donation::class);
    }

    public function isRefunded(): bool
    {
        return $this->refunded_at !== null;
    }

    public function canBeRefunded(): bool
    {
        return $this->status === 'completed' && !$this->isRefunded();
    }
}

