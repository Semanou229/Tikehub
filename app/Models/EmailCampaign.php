<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'name',
        'subject',
        'content',
        'template_type',
        'recipient_criteria',
        'segment_id',
        'status',
        'scheduled_at',
        'sent_at',
        'sent_count',
        'opened_count',
        'clicked_count',
        'bounced_count',
    ];

    protected $casts = [
        'recipient_criteria' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function recipients()
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'campaign_id');
    }
}
