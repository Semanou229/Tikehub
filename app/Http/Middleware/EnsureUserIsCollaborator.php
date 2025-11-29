<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCollaborator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Vérifier si l'utilisateur est un collaborateur (membre d'équipe ou agent)
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Un collaborateur est soit un membre d'équipe, soit un agent
        $isCollaborator = $user->team_id !== null || $user->hasRole('agent');
        
        if (!$isCollaborator && !$user->hasRole('organizer') && !$user->hasRole('admin')) {
            abort(403, 'Accès réservé aux collaborateurs.');
        }
        
        return $next($request);
    }
}

