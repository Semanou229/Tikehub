<?php

if (!function_exists('get_commission_rate')) {
    /**
     * Récupère le taux de commission depuis la base de données ou la config
     * 
     * @return float
     */
    function get_commission_rate(): float
    {
        return (float) \App\Models\PlatformSetting::get('commission_rate', config('platform.commission_rate', 5));
    }
}

