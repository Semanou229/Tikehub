<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'subdomain',
        'subdomain_enabled',
        'organizer_id',
        'title',
        'slug',
        'subdomain',
        'description',
        'category',
        'type',
        'is_virtual',
        'platform_type',
        'meeting_link',
        'meeting_id',
        'meeting_password',
        'virtual_access_instructions',
        'start_date',
        'end_date',
        'venue_name',
        'venue_address',
        'venue_city',
        'venue_country',
        'venue_latitude',
        'venue_longitude',
        'cover_image',
        'gallery',
        'is_published',
        'is_free',
        'status',
        'settings',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
        'is_free' => 'boolean',
        'is_virtual' => 'boolean',
        'gallery' => 'array',
        'settings' => 'array',
        'venue_latitude' => 'decimal:8',
        'venue_longitude' => 'decimal:8',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
            if (empty($event->subdomain) && $event->subdomain_enabled) {
                $event->subdomain = Str::slug($event->title);
            }
        });
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function contests()
    {
        return $this->hasMany(Contest::class);
    }

    public function fundraisings()
    {
        return $this->hasMany(Fundraising::class);
    }

    public function agents()
    {
        return $this->belongsToMany(User::class, 'event_agents', 'event_id', 'agent_id')
            ->withPivot('permissions')
            ->withTimestamps();
    }

    public function scans()
    {
        return $this->hasMany(TicketScan::class);
    }

    public function getSubdomainUrlAttribute()
    {
        $pattern = config('platform.subdomain_pattern', 'ev-{slug}.tikehub.com');
        if ($pattern && $this->slug) {
            $domain = str_replace('{slug}', $this->slug, $pattern);
            return 'https://' . $domain;
        }
        return null;
    }

    public function getTotalSalesAttribute()
    {
        return $this->tickets()->where('status', 'paid')->sum('price');
    }

    public function getTotalTicketsSoldAttribute()
    {
        return $this->tickets()->where('status', 'paid')->count();
    }

    /**
     * Relation avec les logs d'accès virtuel
     */
    public function virtualAccessLogs()
    {
        return $this->hasMany(VirtualEventAccessLog::class);
    }

    /**
     * Obtenir le nombre de participants connectés à l'événement virtuel
     */
    public function getVirtualParticipantsCountAttribute(): int
    {
        return $this->virtualAccessLogs()
            ->where('is_valid', true)
            ->distinct('ticket_id')
            ->count('ticket_id');
    }

    /**
     * Obtenir le taux de présence pour un événement virtuel
     */
    public function getVirtualAttendanceRateAttribute(): float
    {
        $totalTickets = $this->tickets()->where('status', 'paid')->count();
        if ($totalTickets === 0) {
            return 0;
        }

        $participants = $this->virtualParticipantsCount;
        return ($participants / $totalTickets) * 100;
    }
}

