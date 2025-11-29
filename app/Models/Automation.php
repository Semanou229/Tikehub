<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Automation extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'name',
        'description',
        'trigger_type',
        'trigger_conditions',
        'action_type',
        'action_config',
        'delay_minutes',
        'is_active',
        'executed_count',
        'last_executed_at',
    ];

    protected $casts = [
        'trigger_conditions' => 'array',
        'action_config' => 'array',
        'last_executed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function logs()
    {
        return $this->hasMany(AutomationLog::class);
    }
}
