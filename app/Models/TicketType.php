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
}

