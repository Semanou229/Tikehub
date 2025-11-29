<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'automation_id',
        'contact_id',
        'triggered_by_type',
        'triggered_by_id',
        'status',
        'error_message',
        'executed_at',
    ];

    protected $casts = [
        'executed_at' => 'datetime',
    ];

    public function automation()
    {
        return $this->belongsTo(Automation::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function triggeredBy()
    {
        return $this->morphTo();
    }
}
