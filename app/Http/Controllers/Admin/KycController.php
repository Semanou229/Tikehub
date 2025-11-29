<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KycController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('kyc_status', ['pending', 'rejected']);

        if ($request->filled('status')) {
            $query->where('kyc_status', $request->status);
        }

        $kycRequests = $query->with('roles')
            ->latest('kyc_submitted_at')
            ->paginate(20);

        $stats = [
            'pending' => User::where('kyc_status', 'pending')->count(),
            'verified' => User::where('kyc_status', 'verified')->count(),
            'rejected' => User::where('kyc_status', 'rejected')->count(),
        ];

        return view('dashboard.admin.kyc.index', compact('kycRequests', 'stats'));
    }

    public function show(User $user)
    {
        if ($user->kyc_status !== 'pending' && $user->kyc_status !== 'rejected') {
            return redirect()->route('admin.kyc.index')
                ->with('error', 'Cette demande KYC n\'est plus en attente.');
        }

        return view('dashboard.admin.kyc.show', compact('user'));
    }

    public function approve(User $user)
    {
        $user->update([
            'kyc_status' => 'verified',
            'kyc_verified_at' => now(),
        ]);

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC approuvé avec succès.');
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $user->update([
            'kyc_status' => 'rejected',
            'kyc_verified_at' => null,
        ]);

        return redirect()->route('admin.kyc.index')
            ->with('success', 'KYC rejeté.');
    }
}


