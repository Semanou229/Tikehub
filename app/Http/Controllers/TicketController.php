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
        // Vérifier si c'est un achat multi-tickets
        if ($request->has('tickets') && is_array($request->tickets)) {
            $validated = $request->validate([
                'event_id' => 'required|exists:events,id',
                'tickets' => 'required|array',
                'tickets.*' => 'required|integer|min:1|max:10',
                'buyer_name' => 'required|string|max:255',
                'buyer_email' => 'required|email',
                'buyer_phone' => 'nullable|string|max:20',
                'promo_code_id' => 'nullable|exists:promo_codes,id',
                'discount_amount' => 'nullable|numeric|min:0',
            ]);

            $payment = $this->paymentService->processMultipleTicketsPurchase(
                auth()->user(),
                $validated
            );
        } else {
            // Ancien système (un seul type de ticket)
            $validated = $request->validate([
                'event_id' => 'required|exists:events,id',
                'ticket_type_id' => 'required|exists:ticket_types,id',
                'quantity' => 'required|integer|min:1|max:10',
                'buyer_name' => 'required|string|max:255',
                'buyer_email' => 'required|email',
                'buyer_phone' => 'nullable|string|max:20',
                'promo_code_id' => 'nullable|exists:promo_codes,id',
                'discount_amount' => 'nullable|numeric|min:0',
            ]);

            $payment = $this->paymentService->processTicketPurchase(
                auth()->user(),
                $validated
            );
        }

        // Récupérer l'URL de checkout depuis la session ou Moneroo
        $checkoutUrl = session('moneroo_checkout_url_' . $payment->id);
        if ($checkoutUrl) {
            session()->forget('moneroo_checkout_url_' . $payment->id);
            return redirect($checkoutUrl);
        }

        // Si pas d'URL en session, essayer de récupérer depuis Moneroo
        if ($payment->moneroo_transaction_id) {
            try {
                $monerooPayment = $this->paymentService->getMonerooPayment($payment->moneroo_transaction_id);
                if (isset($monerooPayment->checkout_url)) {
                    return redirect($monerooPayment->checkout_url);
                }
            } catch (\Exception $e) {
                \Log::error('Error getting checkout URL', ['error' => $e->getMessage()]);
            }
        }

        return redirect(route('payments.return', ['payment' => $payment->id]));
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

        // Générer le token d'accès virtuel si nécessaire
        if ($ticket->event->is_virtual && !$ticket->virtual_access_token && $ticket->status === 'paid') {
            $ticket->generateVirtualAccessToken();
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

    public function validatePromoCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'event_id' => 'required|exists:events,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $event = Event::findOrFail($request->event_id);
        $amount = (float) $request->amount;

        $promoCode = \App\Models\PromoCode::where('code', $code)
            ->where(function ($q) use ($event) {
                $q->where('event_id', $event->id)
                  ->orWhereNull('event_id');
            })
            ->where('organizer_id', $event->organizer_id)
            ->first();

        if (!$promoCode) {
            return response()->json([
                'valid' => false,
                'message' => 'Code promo invalide ou introuvable.'
            ]);
        }

        if (!$promoCode->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Ce code promo n\'est plus valide ou a expiré.'
            ]);
        }

        if (!$promoCode->meetsMinimumAmount($amount)) {
            return response()->json([
                'valid' => false,
                'message' => 'Le montant minimum pour utiliser ce code est de ' . number_format($promoCode->minimum_amount, 0, ',', ' ') . ' XOF.'
            ]);
        }

        if (auth()->check() && !$promoCode->canBeUsedByUser(auth()->id())) {
            return response()->json([
                'valid' => false,
                'message' => 'Vous avez atteint la limite d\'utilisation de ce code promo.'
            ]);
        }

        $discount = $promoCode->calculateDiscount($amount);
        $finalAmount = max(0, $amount - $discount);

        return response()->json([
            'valid' => true,
            'message' => 'Code promo appliqué avec succès !',
            'promo_code_id' => $promoCode->id,
            'discount_amount' => $discount,
            'original_amount' => $amount,
            'final_amount' => $finalAmount,
        ]);
    }
}

