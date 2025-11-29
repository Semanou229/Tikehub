<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reportable_type',
        'reportable_id',
        'reporter_id',
        'reason',
        'message',
        'status',
        'reviewed_by',
        'reviewed_at',
        'admin_notes',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relation polymorphique : le signalement peut concerner un Event, Contest ou Fundraising
     */
    public function reportable()
    {
        return $this->morphTo();
    }

    /**
     * L'utilisateur qui a fait le signalement
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * L'admin qui a examiné le signalement
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Obtenir le libellé de la raison
     */
    public function getReasonLabelAttribute(): string
    {
        return match($this->reason) {
            'inappropriate_content' => 'Contenu inapproprié',
            'false_information' => 'Informations erronées',
            'spam' => 'Spam',
            'scam' => 'Arnaque',
            'copyright' => 'Violation de droits d\'auteur',
            'other' => 'Autre',
            default => 'Non spécifié',
        };
    }

    /**
     * Obtenir le libellé du statut
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'reviewed' => 'Examiné',
            'resolved' => 'Résolu',
            'dismissed' => 'Rejeté',
            default => 'Inconnu',
        };
    }
}
