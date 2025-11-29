<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'event_id',
        'name',
        'slug',
        'description',
        'form_type',
        'fields',
        'settings',
        'is_active',
        'requires_approval',
        'submissions_count',
    ];

    protected $casts = [
        'fields' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'requires_approval' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($form) {
            if (empty($form->slug)) {
                $form->slug = Str::slug($form->name) . '-' . Str::random(6);
            }
        });
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id');
    }
}
