<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Notifications\TicketReadyNotification;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        // Vérifier si le statut a changé vers "paid" et que le QR code a été généré
        if ($ticket->wasChanged('status') && $ticket->status === 'paid' && $ticket->qr_code) {
            // Envoyer la notification que le billet est prêt
            if ($ticket->buyer) {
                $ticket->buyer->notify(new TicketReadyNotification($ticket));
            }
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
