<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\VirtualEventAccessLog;
use Illuminate\Support\Facades\Log;

class VirtualEventService
{
    /**
     * Valider et enregistrer l'accès à un événement virtuel
     */
    public function validateAndLogAccess(Ticket $ticket, string $token, ?string $ipAddress = null, ?string $userAgent = null): bool
    {
        // Vérifier que l'événement est virtuel
        if (!$ticket->event->is_virtual) {
            return false;
        }

        // Vérifier que le ticket est payé
        if ($ticket->status !== 'paid') {
            return false;
        }

        // Vérifier le token
        if ($ticket->virtual_access_token !== $token) {
            return false;
        }

        // Vérifier que l'événement n'est pas terminé
        if ($ticket->event->end_date && $ticket->event->end_date->isPast()) {
            return false;
        }

        // Vérifier que l'événement a commencé (optionnel - peut être activé avant)
        // if ($ticket->event->start_date && $ticket->event->start_date->isFuture()) {
        //     return false;
        // }

        // Enregistrer l'accès
        VirtualEventAccessLog::create([
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id,
            'user_id' => $ticket->buyer_id,
            'access_token' => $token,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
            'accessed_at' => now(),
            'is_valid' => true,
        ]);

        // Marquer le ticket comme utilisé (optionnel - peut permettre plusieurs accès)
        // $ticket->markVirtualAccessAsUsed();

        Log::info('Accès virtuel validé', [
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id,
            'user_id' => $ticket->buyer_id,
        ]);

        return true;
    }

    /**
     * Obtenir le lien de redirection vers la plateforme de visioconférence
     */
    public function getMeetingRedirectUrl(Event $event): ?string
    {
        if (!$event->is_virtual || !$event->meeting_link) {
            return null;
        }

        $link = $event->meeting_link;

        // Ajouter le mot de passe si nécessaire
        if ($event->meeting_password) {
            // Pour Google Meet, le format est différent
            if ($event->platform_type === 'google_meet') {
                // Google Meet n'utilise pas de mot de passe dans l'URL directement
                // Il faut l'ajouter manuellement ou via l'interface
            } else {
                // Pour Zoom, Teams, etc., on peut ajouter le paramètre
                $separator = parse_url($link, PHP_URL_QUERY) ? '&' : '?';
                $link .= $separator . 'pwd=' . urlencode($event->meeting_password);
            }
        }

        return $link;
    }

    /**
     * Obtenir les statistiques d'accès pour un événement virtuel
     */
    public function getAccessStatistics(Event $event): array
    {
        $totalTickets = $event->tickets()->where('status', 'paid')->count();
        $totalAccesses = $event->virtualAccessLogs()->where('is_valid', true)->count();
        $uniqueParticipants = $event->virtualAccessLogs()
            ->where('is_valid', true)
            ->distinct('ticket_id')
            ->count('ticket_id');

        $attendanceRate = $totalTickets > 0 ? ($uniqueParticipants / $totalTickets) * 100 : 0;

        return [
            'total_tickets' => $totalTickets,
            'total_accesses' => $totalAccesses,
            'unique_participants' => $uniqueParticipants,
            'attendance_rate' => round($attendanceRate, 2),
        ];
    }
}


