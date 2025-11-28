<?php

namespace App\Http\Controllers\Subdomain;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $host = parse_url(config('app.url', 'http://localhost'), PHP_URL_HOST);
        $subdomain = $host ? str_replace('.' . $host, '', $request->getHost()) : $request->getHost();
        $subdomain = str_replace('ev-', '', $subdomain);

        $event = Event::where('slug', $subdomain)
            ->orWhere('subdomain', $subdomain)
            ->where('is_published', true)
            ->firstOrFail();

        $ticketTypes = $event->ticketTypes()->where('is_active', true)->get();

        return view('subdomain.tickets.index', compact('event', 'ticketTypes'));
    }

    public function purchase(Request $request)
    {
        // Rediriger vers la route principale
        return redirect()->route('tickets.purchase', $request->all());
    }
}

