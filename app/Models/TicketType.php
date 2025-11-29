<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
        'sold_quantity',
        'start_sale_date',
        'end_sale_date',
        'is_active',
        'settings',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_sale_date' => 'datetime',
        'end_sale_date' => 'datetime',
        'is_active' => 'boolean',
        'settings' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getAvailableQuantityAttribute()
    {
        return max(0, $this->quantity - $this->sold_quantity);
    }

    public function isOnSale()
    {
        $now = now();
        return $this->is_active 
            && $this->available_quantity > 0
            && $now->gte($this->start_sale_date)
            && $now->lte($this->end_sale_date);
    }

    /**
     * Vérifie si le ticket est bientôt épuisé (moins de 10% ou moins de 20 tickets restants)
     */
    public function isAlmostSoldOut(): bool
    {
        if ($this->quantity <= 0) {
            return false;
        }
        
        $percentageRemaining = ($this->available_quantity / $this->quantity) * 100;
        return $percentageRemaining <= 10 || $this->available_quantity <= 20;
    }

    /**
     * Vérifie s'il y a une forte demande (plus de 70% vendus)
     */
    public function hasHighDemand(): bool
    {
        if ($this->quantity <= 0) {
            return false;
        }
        
        $percentageSold = ($this->sold_quantity / $this->quantity) * 100;
        return $percentageSold >= 70 && !$this->isAlmostSoldOut();
    }

    /**
     * Vérifie si les places sont limitées (moins de 100 tickets au total)
     */
    public function isLimited(): bool
    {
        return $this->quantity > 0 && $this->quantity < 100;
    }

    /**
     * Retourne les badges d'urgence à afficher
     */
    public function getUrgencyBadges(): array
    {
        $badges = [];

        if ($this->isAlmostSoldOut()) {
            $badges[] = [
                'text' => 'Bientôt épuisé',
                'color' => 'red',
                'icon' => 'exclamation-triangle'
            ];
        } elseif ($this->hasHighDemand()) {
            $badges[] = [
                'text' => 'Forte demande',
                'color' => 'orange',
                'icon' => 'fire'
            ];
        }

        if ($this->isLimited()) {
            $badges[] = [
                'text' => 'Places limitées',
                'color' => 'yellow',
                'icon' => 'info-circle'
            ];
        }

        return $badges;
    }
}

