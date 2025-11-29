<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Services\PaymentService;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TicketController extends Controller
{
    protected PaymentService $paymentService;
    protected QrCodeService $qrCodeService;

    public function __construct(PaymentService $paymentService, QrCodeService $qrCodeService)
    {
        $this->paymentService = $paymentService;
        $this->qrCodeService = $qrCodeService;
    }

    public function index(Event $event)
    {
        $ticketTypes = $event->ticketTypes()->where('is_active', true)->get();
        
        // Récupérer les tickets sélectionnés depuis la session si disponibles
        $selectedTickets = session('checkout_tickets', []);
        $checkoutEventId = session('checkout_event_id');
        
        // Nettoyer la session après récupération
        if ($checkoutEventId == $event->id) {
            session()->forget(['checkout_tickets', 'checkout_event_id']);
        }
        
        return view('tickets.index', compact('event', 'ticketTypes', 'selectedTickets'));
    }

    public function checkout(Request $request, Event $event)
    {
        $request->validate([
            'tickets' => 'required|string',
        ]);

        $ticketsData = json_decode($request->tickets, true);
        
        if (!is_array($ticketsData) || empty($ticketsData)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un billet.');
        }

        // Stocker les données dans la session pour le checkout
        session(['checkout_tickets' => $ticketsData, 'checkout_event_id' => $event->id]);

        return redirect()->route('tickets.index', $event);
    }

    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1|max:10',
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'nullable|string|max:20',
        ]);

        $payment = $this->paymentService->processTicketPurchase(
            auth()->user(),
            $validated
        );

        return redirect($payment->moneroo_reference 
            ? route('payments.return', ['payment' => $payment->id])
            : route('dashboard')
        );
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->buyer_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if (!$ticket->qr_code && $ticket->status === 'paid') {
            $this->qrCodeService->generateForTicket($ticket);
            $ticket->refresh();
        }

        return view('tickets.show', compact('ticket'));
    }

    public function download(Ticket $ticket)
    {
        if ($ticket->buyer_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if (!$ticket->qr_code && $ticket->status === 'paid') {
            $this->qrCodeService->generateForTicket($ticket);
            $ticket->refresh();
        }

        $pdf = PDF::loadView('tickets.pdf', compact('ticket'));
        return $pdf->download("billet-{$ticket->code}.pdf");
    }

    public function validateToken(Request $request, string $token)
    {
        $ticket = $this->qrCodeService->validateToken($token);

        if (!$ticket) {
            return response()->json(['valid' => false, 'message' => 'Token invalide ou expiré'], 400);
        }

        if (!$ticket->canBeScanned()) {
            return response()->json([
                'valid' => false,
                'message' => $ticket->isScanned() ? 'Billet déjà scanné' : 'Billet non payé'
            ], 400);
        }

        return response()->json([
            'valid' => true,
            'ticket' => [
                'code' => $ticket->code,
                'event' => $ticket->event->title,
                'buyer_name' => $ticket->buyer_name,
            ]
        ]);
    }
}

