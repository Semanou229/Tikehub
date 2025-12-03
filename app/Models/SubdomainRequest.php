<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubdomainRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'requested_subdomain',
        'content_type',
        'content_id',
        'reason',
        'status',
        'admin_notes',
        'actual_subdomain',
        'approved_by',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a fait la demande
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec l'admin qui a approuvé
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relation polymorphique avec l'événement, concours ou collecte
     */
    public function content()
    {
        return $this->morphTo('content', 'content_type', 'content_id');
    }

    /**
     * Obtenir l'événement associé
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'content_id');
    }

    /**
     * Obtenir le concours associé
     */
    public function contest()
    {
        return $this->belongsTo(Contest::class, 'content_id');
    }

    /**
     * Obtenir la collecte associée
     */
    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class, 'content_id');
    }

    /**
     * Obtenir le titre du contenu associé
     */
    public function getContentTitleAttribute()
    {
        if ($this->content_type === 'event') {
            return $this->event?->title;
        } elseif ($this->content_type === 'contest') {
            return $this->contest?->title;
        } elseif ($this->content_type === 'fundraising') {
            return $this->fundraising?->title;
        }
        return null;
    }

    /**
     * Vérifier si la demande est en attente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Vérifier si la demande est approuvée
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Vérifier si la demande est complétée
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Vérifier si la demande est rejetée
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
