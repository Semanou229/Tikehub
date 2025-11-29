<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'name',
        'description',
        'type',
        'criteria',
        'contacts_count',
        'is_active',
    ];

    protected $casts = [
        'criteria' => 'array',
        'is_active' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    public function emailCampaigns()
    {
        return $this->hasMany(EmailCampaign::class);
    }
}
