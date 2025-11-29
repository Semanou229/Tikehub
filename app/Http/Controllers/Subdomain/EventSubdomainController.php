<?php

namespace App\Http\Controllers\Subdomain;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventSubdomainController extends Controller
{
    public function show(Request $request, $subdomain)
    {
        $event = Event::where('subdomain', $subdomain)
            ->where('subdomain_enabled', true)
            ->where('is_published', true)
            ->where('status', 'published')
            ->with(['organizer', 'ticketTypes' => function ($q) {
                $q->where('is_active', true)
                  ->where('sale_start_date', '<=', now())
                  ->where('sale_end_date', '>=', now());
            }])
            ->firstOrFail();

        return view('subdomain.event.show', compact('event'));
    }
}
