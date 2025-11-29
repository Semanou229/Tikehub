<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistiques du profil
        $stats = [
            'total_tickets' => $user->tickets()->where('status', 'paid')->count(),
            'total_spent' => $user->payments()->where('status', 'completed')->sum('amount'),
            'upcoming_events' => $user->tickets()
                ->where('status', 'paid')
                ->whereHas('event', function ($q) {
                    $q->where('start_date', '>=', now());
                })
                ->count(),
        ];
        
        return view('dashboard.buyer.profile.index', compact('user', 'stats'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Vérifier le mot de passe actuel si un nouveau mot de passe est fourni
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])->withInput();
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Gérer l'upload de l'avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('buyer.profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
