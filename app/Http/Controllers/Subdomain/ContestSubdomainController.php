<?php

namespace App\Http\Controllers\Subdomain;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;

class ContestSubdomainController extends Controller
{
    public function show(Request $request, $subdomain)
    {
        $contest = Contest::where('subdomain', $subdomain)
            ->where('subdomain_enabled', true)
            ->where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['organizer', 'candidates' => function ($q) {
                $q->orderBy('number');
            }])
            ->firstOrFail();

        // Calculer le classement
        $ranking = $contest->getRanking();

        return view('subdomain.contest.show', compact('contest', 'ranking'));
    }
}
