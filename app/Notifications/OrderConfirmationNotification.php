<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class OrderConfirmationNotification extends Notification
{
    use Queueable;

    protected $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
        $tickets = $this->payment->tickets;
        $ticketCount = $tickets->count();

        $mail = (new MailMessage)
            ->subject('Confirmation de votre commande - Tikehub')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('🎉 **Votre commande a été confirmée !**')
            ->line('Nous avons bien reçu votre paiement pour l\'événement : **' . $event->title . '**')
            ->line('**Détails de votre commande :**')
            ->line('• Nombre de billets : ' . $ticketCount)
            ->line('• Montant total : ' . number_format($this->payment->amount, 0, ',', ' ') . ' ' . $this->payment->currency);

        if ($this->payment->discount_amount > 0) {
            $mail->line('• Réduction appliquée : -' . number_format($this->payment->discount_amount, 0, ',', ' ') . ' ' . $this->payment->currency);
        }

        $mail->line('• Numéro de commande : #' . $this->payment->id)
            ->line('• Date : ' . $this->payment->created_at->format('d/m/Y à H:i'));

        if ($event->start_date) {
            $mail->line('• Date de l\'événement : ' . $event->start_date->format('d/m/Y à H:i'));
        }

        if ($event->venue) {
            $mail->line('• Lieu : ' . $event->venue);
        }

        $mail->line('**Vos billets :**')
            ->line('Vous pouvez télécharger vos billets depuis votre compte.');

        return $mail
            ->action('Voir mes billets', route('dashboard'))
            ->line('Nous vous remercions pour votre confiance et vous souhaitons un excellent événement !')
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
            'amount' => $this->payment->amount,
            'event_title' => $this->payment->event->title,
        ];
    }
}
