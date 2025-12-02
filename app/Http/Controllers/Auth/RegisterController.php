<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|in:buyer,organizer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'email_verified_at' => null, // L'email n'est pas vérifié au départ
        ]);

        $role = $request->role ?? 'buyer';
        $user->assignRole($role);

        // Envoyer l'email de vérification
        $user->notify(new VerifyEmailNotification());

        // Envoyer l'email de bienvenue
        $user->notify(new WelcomeEmailNotification());

        // Connecter l'utilisateur
        Auth::login($user);

        // Rediriger vers la page de vérification d'email
        return redirect()->route('verification.notice')->with('success', 'Votre compte a été créé avec succès ! Veuillez vérifier votre email pour activer votre compte.');
    }
}


