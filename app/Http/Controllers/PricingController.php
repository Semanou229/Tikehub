<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlatformSetting;

class PricingController extends Controller
{
    public function index()
    {
        // Récupérer le taux de commission depuis les paramètres
        $commissionRate = PlatformSetting::get('commission_rate', 5);
        
        // Récupérer d'autres paramètres utiles
        $minWithdrawal = PlatformSetting::get('min_withdrawal_amount', 1000);
        $withdrawalProcessingDays = PlatformSetting::get('withdrawal_processing_days', 3);
        
        return view('pages.pricing', compact('commissionRate', 'minWithdrawal', 'withdrawalProcessingDays'));
    }
}
