<?php

namespace App\Http\Controllers\Subdomain;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventPageController extends Controller
{
    public function show(Request $request)
    {
        $host = parse_url(config('app.url', 'http://localhost'), PHP_URL_HOST);
        $subdomain = $host ? str_replace('.' . $host, '', $request->getHost()) : $request->getHost();
        $subdomain = str_replace('ev-', '', $subdomain);

        $event = Event::where('slug', $subdomain)
            ->orWhere('subdomain', $subdomain)
            ->where('is_published', true)
            ->firstOrFail();

        $event->load(['ticketTypes', 'contests', 'fundraisings']);

        return view('subdomain.event.show', compact('event'));
    }
}

