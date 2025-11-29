<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.organizer.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
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

        return redirect()->route('organizer.profile.index')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function kyc()
    {
        $user = auth()->user();
        return view('dashboard.organizer.profile.kyc', compact('user'));
    }

    public function submitKyc(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'kyc_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'kyc_document_type' => 'required|in:id_card,passport,business_license',
        ]);

        if ($request->hasFile('kyc_document')) {
            $validated['kyc_document'] = $request->file('kyc_document')->store('kyc', 'public');
            $validated['kyc_status'] = 'pending';
            $validated['kyc_submitted_at'] = now();
        }

        $user->update($validated);

        return redirect()->route('organizer.profile.kyc')
            ->with('success', 'Document KYC soumis avec succès. Il sera vérifié par notre équipe.');
    }
}

