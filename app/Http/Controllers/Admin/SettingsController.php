<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.settings');
    }

    public function update(Request $request)
    {
        // Cette fonctionnalité peut être étendue pour gérer les paramètres de la plateforme
        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}

