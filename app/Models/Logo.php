<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Logo extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'path',
        'width',
        'height',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'width' => 'integer',
        'height' => 'integer',
    ];

    /**
     * Récupérer l'URL du logo
     */
    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->path);
    }

    /**
     * Récupérer un logo par type
     */
    public static function getByType($type)
    {
        return self::where('type', $type)
            ->where('is_active', true)
            ->first();
    }

    /**
     * Récupérer l'URL d'un logo par type
     */
    public static function getUrlByType($type, $default = null)
    {
        $logo = self::getByType($type);
        
        if ($logo) {
            return $logo->url;
        }

        return $default ?? asset('images/default-logo.png');
    }

    /**
     * Supprimer le fichier associé
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($logo) {
            if ($logo->path && Storage::disk('public')->exists($logo->path)) {
                Storage::disk('public')->delete($logo->path);
            }
        });
    }
}
