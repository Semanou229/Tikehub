<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\KycStatusChangedNotification;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Vérifier si le statut KYC a changé
        if ($user->wasChanged('kyc_status')) {
            $oldStatus = $user->getOriginal('kyc_status');
            $newStatus = $user->kyc_status;

            // Envoyer la notification de changement de statut KYC
            $user->notify(new KycStatusChangedNotification($newStatus));
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
