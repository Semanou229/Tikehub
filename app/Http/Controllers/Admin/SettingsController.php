<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = PlatformSetting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        
        return view('dashboard.admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable',
        ]);

        foreach ($validated['settings'] as $key => $value) {
            $setting = PlatformSetting::where('key', $key)->first();
            
            if ($setting) {
                // Convertir la valeur selon le type
                if ($setting->type === 'boolean') {
                    $value = $request->has("settings.{$key}") ? '1' : '0';
                } elseif ($setting->type === 'json' && is_array($value)) {
                    $value = json_encode($value);
                }
                
                $setting->update(['value' => $value]);
            }
        }

        // Mettre à jour le cache de configuration si nécessaire
        cache()->forget('platform_settings');

        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:platform_settings,key',
            'value' => 'nullable',
            'type' => 'required|in:string,integer,float,boolean,json',
            'group' => 'required|string',
            'description' => 'nullable|string',
        ]);

        PlatformSetting::create($validated);

        return back()->with('success', 'Paramètre ajouté avec succès.');
    }

    public function destroy($id)
    {
        $setting = PlatformSetting::findOrFail($id);
        
        // Empêcher la suppression de certains paramètres critiques
        $protectedKeys = ['commission_rate', 'min_withdrawal_amount', 'kyc_required_for_withdrawal'];
        
        if (in_array($setting->key, $protectedKeys)) {
            return back()->with('error', 'Ce paramètre ne peut pas être supprimé.');
        }

        $setting->delete();

        return back()->with('success', 'Paramètre supprimé avec succès.');
    }
}
