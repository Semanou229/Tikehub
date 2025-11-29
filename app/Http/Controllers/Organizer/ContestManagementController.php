<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;

class ContestManagementController extends Controller
{
    public function index()
    {
        $contests = Contest::where('organizer_id', auth()->id())
            ->withCount(['votes', 'candidates'])
            ->latest()
            ->paginate(15);

        return view('dashboard.organizer.contests.index', compact('contests'));
    }

    public function destroy(Contest $contest)
    {
        // Vérifier que le concours appartient à l'organisateur
        if ($contest->organizer_id !== auth()->id()) {
            abort(403);
        }

        // Vérifier qu'il n'y a pas de votes
        if ($contest->votes()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un concours avec des votes.');
        }

        $contest->delete();

        return redirect()->route('organizer.contests.index')
            ->with('success', 'Concours supprimé avec succès.');
    }
}


