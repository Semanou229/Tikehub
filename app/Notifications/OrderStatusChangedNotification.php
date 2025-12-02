<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    protected $payment;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment, $oldStatus, $newStatus)
    {
        $this->payment = $payment;
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
        $event = $this->payment->event;
        $statusText = [
            'pending' => 'en attente',
            'paid' => 'payé',
            'failed' => 'échoué',
            'cancelled' => 'annulé',
            'refunded' => 'remboursé'
        ][$this->newStatus] ?? $this->newStatus;

        $mail = (new MailMessage)
            ->subject('Mise à jour du statut de votre commande - Tikehub')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Le statut de votre commande #' . $this->payment->id . ' pour l\'événement **' . $event->title . '** a été mis à jour.');

        if ($this->newStatus === 'paid') {
            $mail->line('✅ **Votre paiement a été confirmé !**')
                ->line('Votre commande est maintenant **payée** et vos billets sont disponibles.')
                ->action('Télécharger mes billets', route('dashboard'));
        } elseif ($this->newStatus === 'failed') {
            $mail->line('❌ **Échec du paiement**')
                ->line('Votre paiement n\'a pas pu être traité. Veuillez réessayer.')
                ->action('Réessayer le paiement', route('payments.show', $this->payment));
        } elseif ($this->newStatus === 'cancelled') {
            $mail->line('⚠️ **Commande annulée**')
                ->line('Votre commande a été annulée. Si vous avez des questions, contactez notre support.')
                ->action('Contacter le support', route('support.tickets.create'));
        } elseif ($this->newStatus === 'refunded') {
            $mail->line('💰 **Remboursement effectué**')
                ->line('Votre commande a été remboursée. Le montant sera crédité sur votre compte dans les prochains jours.');
        } else {
            $mail->line('Le statut de votre commande est maintenant : **' . $statusText . '**.');
        }

        return $mail
            ->line('**Détails de la commande :**')
            ->line('• Numéro : #' . $this->payment->id)
            ->line('• Montant : ' . number_format($this->payment->amount, 0, ',', ' ') . ' ' . $this->payment->currency)
            ->line('• Nouveau statut : ' . $statusText)
            ->action('Voir ma commande', route('dashboard'))
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
            'payment_id' => $this->payment->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }
}
