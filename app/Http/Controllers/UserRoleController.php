<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    /**
     * Permet à un utilisateur de devenir organisateur
     */
    public function becomeOrganizer(Request $request)
    {
        $user = auth()->user();
        
        // Vérifier que l'utilisateur est authentifié
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour devenir organisateur.');
        }
        
        // Vérifier si l'utilisateur est déjà organisateur
        if ($user->isOrganizer()) {
            return redirect()->route('dashboard')->with('info', 'Vous êtes déjà organisateur.');
        }
        
        // Vérifier si l'utilisateur est admin (les admins ne peuvent pas devenir organisateurs via ce bouton)
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')->with('info', 'Les administrateurs ont déjà tous les droits.');
        }
        
        try {
            // Récupérer le rôle organisateur
            $organizerRole = Role::where('name', 'organizer')->where('guard_name', 'web')->first();
            
            if (!$organizerRole) {
                Log::error('Rôle organisateur non trouvé');
                return back()->with('error', 'Une erreur est survenue. Veuillez contacter le support.');
            }
            
            // Assigner le rôle organisateur (l'utilisateur peut avoir plusieurs rôles)
            if (!$user->hasRole('organizer')) {
                $user->assignRole('organizer');
                
                Log::info('Utilisateur devenu organisateur', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            }
            
            return redirect()->route('dashboard')->with('success', 'Félicitations ! Vous êtes maintenant organisateur. Vous pouvez maintenant créer et gérer vos événements.');
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du changement de rôle', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Une erreur est survenue lors du changement de statut. Veuillez réessayer ou contacter le support.');
        }
    }
}

