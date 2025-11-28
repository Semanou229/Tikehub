<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'event_id',
        'scanned_by',
        'scan_type',
        'ip_address',
        'user_agent',
        'location',
        'is_valid',
        'notes',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'location' => 'array',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}

