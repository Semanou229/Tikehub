<?php

namespace App\Observers;

use App\Models\Withdrawal;
use App\Notifications\WithdrawalStatusChangedNotification;

class WithdrawalObserver
{
    /**
     * Handle the Withdrawal "created" event.
     */
    public function created(Withdrawal $withdrawal): void
    {
        // Notification initiale de création (optionnel)
    }

    /**
     * Handle the Withdrawal "updated" event.
     */
    public function updated(Withdrawal $withdrawal): void
    {
        // Vérifier si le statut a changé
        if ($withdrawal->wasChanged('status')) {
            $oldStatus = $withdrawal->getOriginal('status');
            $newStatus = $withdrawal->status;

            // Envoyer la notification de changement de statut
            if ($withdrawal->user) {
                $withdrawal->user->notify(new WithdrawalStatusChangedNotification($withdrawal, $oldStatus, $newStatus));
            }
        }
    }

    /**
     * Handle the Withdrawal "deleted" event.
     */
    public function deleted(Withdrawal $withdrawal): void
    {
        //
    }

    /**
     * Handle the Withdrawal "restored" event.
     */
    public function restored(Withdrawal $withdrawal): void
    {
        //
    }

    /**
     * Handle the Withdrawal "force deleted" event.
     */
    public function forceDeleted(Withdrawal $withdrawal): void
    {
        //
    }
}
