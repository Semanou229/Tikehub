<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Services\VirtualEventService;
use Illuminate\Http\Request;

class VirtualEventController extends Controller
{
    protected VirtualEventService $virtualEventService;

    public function __construct(VirtualEventService $virtualEventService)
    {
        $this->virtualEventService = $virtualEventService;
    }

    /**
     * Accès à un événement virtuel via token
     */
    public function access(Request $request, Ticket $ticket, string $token)
    {
        // Valider l'accès
        $isValid = $this->virtualEventService->validateAndLogAccess(
            $ticket,
            $token,
            $request->ip(),
            $request->userAgent()
        );

        if (!$isValid) {
            return redirect()->route('home')
                ->with('error', 'Accès refusé. Vérifiez que votre billet est valide et que l\'événement n\'est pas terminé.');
        }

        // Obtenir le lien de redirection
        $meetingUrl = $this->virtualEventService->getMeetingRedirectUrl($ticket->event);

        if (!$meetingUrl) {
            return redirect()->route('home')
                ->with('error', 'Lien de visioconférence non configuré pour cet événement.');
        }

        // Rediriger vers la plateforme
        return redirect($meetingUrl);
    }

    /**
     * Accès via QR code (scan)
     */
    public function accessByQr(Request $request, string $token)
    {
        // Décoder le token QR
        $qrCodeService = app(\App\Services\QrCodeService::class);
        $ticket = $qrCodeService->validateToken($token);

        if (!$ticket) {
            return redirect()->route('home')
                ->with('error', 'QR code invalide ou expiré.');
        }

        // Vérifier que c'est un événement virtuel
        if (!$ticket->event->is_virtual) {
            return redirect()->route('tickets.show', $ticket)
                ->with('info', 'Cet événement n\'est pas virtuel.');
        }

        // Utiliser le token d'accès virtuel
        if (!$ticket->virtual_access_token) {
            $ticket->generateVirtualAccessToken();
        }

        return redirect()->route('virtual-events.access', [
            'ticket' => $ticket->id,
            'token' => $ticket->virtual_access_token
        ]);
    }
}
