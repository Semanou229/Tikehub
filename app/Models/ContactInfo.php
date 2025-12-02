<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'map_embed_code',
        'opening_hours',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public static function getInstance()
    {
        return static::firstOrCreate([]);
    }
}
