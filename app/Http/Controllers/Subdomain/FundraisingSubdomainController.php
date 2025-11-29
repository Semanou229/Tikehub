<?php

namespace App\Http\Controllers\Subdomain;

use App\Http\Controllers\Controller;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class FundraisingSubdomainController extends Controller
{
    public function show(Request $request, $subdomain)
    {
        $fundraising = Fundraising::where('subdomain', $subdomain)
            ->where('subdomain_enabled', true)
            ->where('is_published', true)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['organizer', 'donations' => function ($q) {
                $q->where('status', 'completed')
                  ->latest()
                  ->take(10);
            }])
            ->firstOrFail();

        return view('subdomain.fundraising.show', compact('fundraising'));
    }
}
