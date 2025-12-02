<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Ticket;

class TicketReadyNotification extends Notification
{
    use Queueable;

    protected $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
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
        $event = $this->ticket->event;
        $payment = $this->ticket->payment;

        $mail = (new MailMessage)
            ->subject('Vos billets sont prêts - ' . $event->title . ' - Tikehub')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('🎫 **Vos billets sont maintenant disponibles !**')
            ->line('Votre commande pour l\'événement **' . $event->title . '** a été confirmée.');

        if ($event->start_date) {
            $mail->line('**Date de l\'événement :** ' . $event->start_date->format('d/m/Y à H:i'));
        }

        if ($event->venue) {
            $mail->line('**Lieu :** ' . $event->venue);
        }

        if ($event->is_virtual && $this->ticket->virtual_access_token) {
            $mail->line('**Lien d\'accès virtuel :** ' . route('events.virtual', ['token' => $this->ticket->virtual_access_token]));
        }

        $mail->line('**Numéro de billet :** #' . $this->ticket->id)
            ->line('**Type de billet :** ' . $this->ticket->ticketType->name ?? 'Standard')
            ->line('**Prix :** ' . number_format($this->ticket->price, 0, ',', ' ') . ' ' . ($payment->currency ?? 'XOF'));

        if ($this->ticket->qr_code) {
            $mail->line('Un QR code a été généré pour votre billet. Vous pouvez le télécharger depuis votre compte.');
        }

        return $mail
            ->action('Télécharger mes billets', route('dashboard'))
            ->line('**Important :** Présentez votre billet (QR code ou PDF) à l\'entrée de l\'événement.')
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
            'ticket_id' => $this->ticket->id,
            'event_title' => $this->ticket->event->title,
        ];
    }
}
