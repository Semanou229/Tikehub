<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'mobile_network',
        'country_code',
        'phone_number',
        'bank_name',
        'account_number',
        'account_holder_name',
        'iban',
        'swift_code',
        'crypto_currency',
        'crypto_wallet_address',
        'crypto_network',
        'status',
        'rejection_reason',
        'processed_at',
        'processed_by',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getPaymentDetailsAttribute()
    {
        switch ($this->payment_method) {
            case 'mobile_money':
                return [
                    'type' => 'Mobile Money',
                    'network' => $this->mobile_network,
                    'phone' => ($this->country_code ?? '') . ' ' . ($this->phone_number ?? ''),
                ];
            case 'bank_transfer':
                return [
                    'type' => 'Virement bancaire',
                    'bank' => $this->bank_name,
                    'account' => $this->account_number,
                    'holder' => $this->account_holder_name,
                    'iban' => $this->iban,
                ];
            case 'crypto':
                return [
                    'type' => 'Crypto-monnaie',
                    'currency' => $this->crypto_currency,
                    'address' => $this->crypto_wallet_address,
                    'network' => $this->crypto_network,
                ];
            default:
                return [];
        }
    }
}
