<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user', 'processor']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $withdrawals = $query->latest()->paginate(20);

        // Statistiques
        $stats = [
            'total' => Withdrawal::count(),
            'pending' => Withdrawal::where('status', 'pending')->count(),
            'approved' => Withdrawal::where('status', 'approved')->count(),
            'completed' => Withdrawal::where('status', 'completed')->count(),
            'rejected' => Withdrawal::where('status', 'rejected')->count(),
            'total_amount' => Withdrawal::where('status', '!=', 'cancelled')->sum('amount'),
            'pending_amount' => Withdrawal::where('status', 'pending')->sum('amount'),
        ];

        return view('dashboard.admin.withdrawals.index', compact('withdrawals', 'stats'));
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['user', 'processor']);
        
        return view('dashboard.admin.withdrawals.show', compact('withdrawal'));
    }

    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $withdrawal->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        // TODO: Envoyer une notification à l'organisateur

        return back()->with('success', 'Demande de retrait approuvée avec succès.');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $withdrawal->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        // TODO: Envoyer une notification à l'organisateur

        return back()->with('success', 'Demande de retrait rejetée.');
    }

    public function complete(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'approved') {
            return back()->with('error', 'Seules les demandes approuvées peuvent être complétées.');
        }

        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $withdrawal->update([
            'status' => 'completed',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? ($withdrawal->admin_notes ?? null),
        ]);

        // TODO: Envoyer une notification à l'organisateur

        return back()->with('success', 'Retrait marqué comme complété.');
    }
}
