<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Withdrawal;

class WithdrawalStatusChangedNotification extends Notification
{
    use Queueable;

    protected $withdrawal;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Withdrawal $withdrawal, $oldStatus, $newStatus)
    {
        $this->withdrawal = $withdrawal;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
            'approved' => 'approuvé',
            'processing' => 'en cours de traitement',
            'completed' => 'complété',
            'rejected' => 'rejeté',
            'cancelled' => 'annulé'
        ][$this->newStatus] ?? $this->newStatus;

        $mail = (new MailMessage)
            ->subject('Mise à jour du statut de votre demande de retrait - Tikehub')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Le statut de votre demande de retrait #' . $this->withdrawal->id . ' a été mis à jour.');

        if ($this->newStatus === 'approved') {
            $mail->line('✅ **Votre demande de retrait a été approuvée !**')
                ->line('Montant : ' . number_format($this->withdrawal->amount, 0, ',', ' ') . ' ' . $this->withdrawal->currency)
                ->line('Votre retrait sera traité dans les plus brefs délais.');
        } elseif ($this->newStatus === 'completed') {
            $mail->line('🎉 **Votre retrait a été complété !**')
                ->line('Montant : ' . number_format($this->withdrawal->amount, 0, ',', ' ') . ' ' . $this->withdrawal->currency)
                ->line('Les fonds ont été transférés sur votre compte.');
        } elseif ($this->newStatus === 'rejected') {
            $mail->line('❌ **Votre demande de retrait a été rejetée**')
                ->line('Montant : ' . number_format($this->withdrawal->amount, 0, ',', ' ') . ' ' . $this->withdrawal->currency);
            
            if ($this->withdrawal->rejection_reason) {
                $mail->line('**Raison :** ' . $this->withdrawal->rejection_reason);
            }
            
            $mail->line('Si vous avez des questions, veuillez nous contacter.');
        } else {
            $mail->line('Statut actuel : **' . $statusText . '**')
                ->line('Montant : ' . number_format($this->withdrawal->amount, 0, ',', ' ') . ' ' . $this->withdrawal->currency);
        }

        return $mail
            ->action('Voir mes retraits', route('organizer.wallet.index'))
            ->line('Si vous avez des questions, n\'hésitez pas à nous contacter.')
            ->salutation('Cordialement, L\'équipe Tikehub');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'withdrawal_id' => $this->withdrawal->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'amount' => $this->withdrawal->amount,
        ];
    }
}
