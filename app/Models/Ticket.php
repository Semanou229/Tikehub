<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'ticket_type_id',
        'buyer_id',
        'agent_id',
        'code',
        'qr_code',
        'qr_token',
        'virtual_access_token', // Token unique pour accès virtuel
        'virtual_access_used_at', // Date d'utilisation du token virtuel
        'price',
        'status',
        'payment_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'is_physical',
        'physical_number',
        'scanned_at',
        'scanned_by',
        'metadata',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'scanned_at' => 'datetime',
        'virtual_access_used_at' => 'datetime',
        'is_physical' => 'boolean',
        'metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->code)) {
                $ticket->code = strtoupper(Str::random(12));
            }
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function scans()
    {
        return $this->hasMany(TicketScan::class);
    }

    public function isScanned(): bool
    {
        return $this->scanned_at !== null;
    }

    public function canBeScanned(): bool
    {
        return $this->status === 'paid' && !$this->isScanned();
    }

    public function generateQrToken(): string
    {
        $payload = [
            'ticket_id' => $this->id,
            'code' => $this->code,
            'exp' => now()->addSeconds(config('qrcode.ttl'))->timestamp,
        ];

        $secret = config('qrcode.secret_key');
        $signature = hash_hmac('sha256', json_encode($payload), $secret);
        
        $this->qr_token = base64_encode(json_encode($payload)) . '.' . $signature;
        $this->save();

        return $this->qr_token;
    }

    public function validateQrToken(string $token): bool
    {
        if ($this->qr_token !== $token) {
            return false;
        }

        $parts = explode('.', $token);
        if (count($parts) !== 2) {
            return false;
        }

        $payload = json_decode(base64_decode($parts[0]), true);
        if (!$payload || !isset($payload['exp'])) {
            return false;
        }

        if (now()->timestamp > $payload['exp']) {
            return false;
        }

        $secret = config('qrcode.secret_key');
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $secret);

        return hash_equals($expectedSignature, $parts[1]);
    }

    /**
     * Générer un token unique pour l'accès virtuel
     */
    public function generateVirtualAccessToken(): string
    {
        if ($this->virtual_access_token) {
            return $this->virtual_access_token;
        }

        $token = Str::random(64);
        $this->virtual_access_token = $token;
        $this->save();

        return $token;
    }

    /**
     * Vérifier si le ticket a déjà été utilisé pour un événement virtuel
     */
    public function isVirtualAccessUsed(): bool
    {
        return $this->virtual_access_used_at !== null;
    }

    /**
     * Marquer le ticket comme utilisé pour un événement virtuel
     */
    public function markVirtualAccessAsUsed(): void
    {
        if (!$this->isVirtualAccessUsed()) {
            $this->virtual_access_used_at = now();
            $this->save();
        }
    }

    /**
     * Obtenir le lien d'accès virtuel
     */
    public function getVirtualAccessUrl(): ?string
    {
        if (!$this->event->is_virtual || !$this->virtual_access_token) {
            return null;
        }

        return route('virtual-events.access', [
            'ticket' => $this->id,
            'token' => $this->virtual_access_token
        ]);
    }

    /**
     * Relation avec les logs d'accès virtuel
     */
    public function virtualAccessLogs()
    {
        return $this->hasMany(VirtualEventAccessLog::class);
    }
}

