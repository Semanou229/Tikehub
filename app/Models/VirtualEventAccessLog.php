<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualEventAccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'event_id',
        'user_id',
        'access_token',
        'ip_address',
        'user_agent',
        'accessed_at',
        'is_valid',
        'metadata',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
        'is_valid' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Le ticket concerné
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * L'événement concerné
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * L'utilisateur qui a accédé
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
