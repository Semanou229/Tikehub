<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Vérifier que le hash correspond
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Lien de vérification invalide.');
        }

        // Vérifier que l'email n'est pas déjà vérifié
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Votre email est déjà vérifié.');
        }

        // Marquer l'email comme vérifié
        if ($user->markEmailAsVerified()) {
            return redirect()->route('dashboard')->with('success', 'Votre email a été vérifié avec succès !');
        }

        return redirect()->route('dashboard')->with('error', 'Erreur lors de la vérification de votre email.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard')->with('info', 'Votre email est déjà vérifié.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Un nouveau lien de vérification a été envoyé à votre adresse email.');
    }
}
