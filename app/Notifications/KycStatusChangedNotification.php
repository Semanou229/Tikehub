<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KycStatusChangedNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $reason = null)
    {
        $this->status = $status;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = [
            'pending' => 'en attente',
            'verified' => 'vérifié',
            'rejected' => 'rejeté'
        ][$this->status] ?? $this->status;

        $mail = (new MailMessage)
            ->subject('Mise à jour de votre vérification d\'identité (KYC) - Tikehub')
            ->greeting('Bonjour ' . $notifiable->name . ' !');

        if ($this->status === 'verified') {
            $mail->line('🎉 **Excellente nouvelle !**')
                ->line('Votre demande de vérification d\'identité (KYC) a été **approuvée**.')
                ->line('Vous pouvez maintenant profiter de toutes les fonctionnalités de Tikehub sans restriction.')
                ->action('Accéder à mon compte', route('dashboard'));
        } elseif ($this->status === 'rejected') {
            $mail->line('❌ **Demande de vérification rejetée**')
                ->line('Votre demande de vérification d\'identité (KYC) a été **rejetée**.');
            
            if ($this->reason) {
                $mail->line('**Raison :** ' . $this->reason);
            }
            
            $mail->line('Vous pouvez soumettre une nouvelle demande avec des documents valides.')
                ->action('Soumettre une nouvelle demande', route('dashboard'));
        } else {
            $mail->line('Votre demande de vérification d\'identité (KYC) est maintenant **' . $statusText . '**.')
                ->line('Nous examinerons votre demande dans les plus brefs délais.')
                ->action('Voir le statut', route('dashboard'));
        }

        return $mail->salutation('Cordialement, L\'équipe Tikehub');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
            'reason' => $this->reason,
        ];
    }
}
