<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'company_name',
        'bio',
        'kyc_status',
        'kyc_document',
        'kyc_document_type',
        'kyc_verified_at',
        'kyc_submitted_at',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'buyer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'user_id');
    }

    public function agentEvents()
    {
        return $this->belongsToMany(Event::class, 'event_agents', 'agent_id', 'event_id')
            ->withPivot('permissions')
            ->withTimestamps();
    }

    public function isOrganizer(): bool
    {
        return $this->hasRole('organizer');
    }

    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isKycVerified(): bool
    {
        return $this->kyc_status === 'verified' && $this->kyc_verified_at !== null;
    }
}
