<?php

namespace App\Helpers;

use App\Models\Logo;

class LogoHelper
{
    /**
     * Récupérer l'URL d'un logo par type
     */
    public static function getUrl($type, $default = null)
    {
        return Logo::getUrlByType($type, $default);
    }

    /**
     * Récupérer le logo complet par type
     */
    public static function get($type)
    {
        return Logo::getByType($type);
    }

    /**
     * Récupérer le chemin absolu pour PDF
     */
    public static function getPathForPdf($type)
    {
        $logo = Logo::getByType($type);
        
        if ($logo && file_exists(public_path('storage/' . $logo->path))) {
            return public_path('storage/' . $logo->path);
        }
        
        return null;
    }
}


