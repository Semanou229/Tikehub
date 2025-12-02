<?php

namespace App\Observers;

use App\Models\Payment;
use App\Notifications\OrderConfirmationNotification;
use App\Notifications\OrderStatusChangedNotification;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        // Ne rien faire à la création, on attendra que le statut soit "paid"
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        // Vérifier si le statut a changé
        if ($payment->wasChanged('status')) {
            $oldStatus = $payment->getOriginal('status');
            $newStatus = $payment->status;

            // Si le paiement vient d'être confirmé (paid)
            if ($newStatus === 'paid' && $oldStatus !== 'paid') {
                // Envoyer la confirmation de commande
                if ($payment->user) {
                    $payment->user->notify(new OrderConfirmationNotification($payment));
                }
            } else {
                // Envoyer la notification de changement de statut
                if ($payment->user) {
                    $payment->user->notify(new OrderStatusChangedNotification($payment, $oldStatus, $newStatus));
                }
            }
        }
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
