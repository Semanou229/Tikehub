<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'event_id',
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'used_count',
        'usage_limit_per_user',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
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

    public function usages()
    {
        return $this->hasMany(PromoCodeUsage::class);
    }

    /**
     * Vérifier si le code promo est valide
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculer le montant de la réduction
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($amount * $this->discount_value) / 100;
            
            if ($this->maximum_discount) {
                $discount = min($discount, $this->maximum_discount);
            }
        } else {
            $discount = $this->discount_value;
        }

        return round($discount, 2);
    }

    /**
     * Vérifier si le montant minimum est respecté
     */
    public function meetsMinimumAmount(float $amount): bool
    {
        if (!$this->minimum_amount) {
            return true;
        }

        return $amount >= $this->minimum_amount;
    }

    /**
     * Vérifier si l'utilisateur peut utiliser ce code
     */
    public function canBeUsedByUser(int $userId): bool
    {
        if (!$this->usage_limit_per_user) {
            return true;
        }

        $userUsageCount = $this->usages()
            ->where('user_id', $userId)
            ->count();

        return $userUsageCount < $this->usage_limit_per_user;
    }
}
