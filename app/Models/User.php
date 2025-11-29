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
        'team_id',
        'team_role',
        'team_permissions',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_verified_at' => 'datetime',
        'kyc_submitted_at' => 'datetime',
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

    public function needsKycForWithdrawal(): bool
    {
        // Les buyers n'ont pas besoin de KYC
        if ($this->hasRole('buyer')) {
            return false;
        }
        
        // Les organisateurs ont besoin de KYC vérifié pour les retraits
        if ($this->hasRole('organizer')) {
            return !$this->isKycVerified();
        }
        
        return false;
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'organizer_id');
    }

    public function assignedContacts()
    {
        return $this->hasMany(Contact::class, 'assigned_to');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function teamTasks()
    {
        return $this->hasMany(TeamTask::class, 'assigned_to');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
