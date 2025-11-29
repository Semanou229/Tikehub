<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class FundraisingManagementController extends Controller
{
    public function index()
    {
        $fundraisings = Fundraising::where('organizer_id', auth()->id())
            ->withCount('donations')
            ->latest()
            ->paginate(15);

        return view('dashboard.organizer.fundraisings.index', compact('fundraisings'));
    }

    public function destroy(Fundraising $fundraising)
    {
        // Vérifier que la collecte appartient à l'organisateur
        if ($fundraising->organizer_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier qu'il n'y a pas de dons
        if ($fundraising->donations()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une collecte avec des dons.');
        }

        $fundraising->delete();

        return redirect()->route('organizer.fundraisings.index')
            ->with('success', 'Collecte de fonds supprimée avec succès.');
    }
}


