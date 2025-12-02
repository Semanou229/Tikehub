<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $role = $notifiable->roles->first()?->name ?? 'acheteur';
        $roleText = $role === 'organizer' ? 'organisateur' : 'acheteur';

        return (new MailMessage)
            ->subject('Bienvenue sur Tikehub ! 🎉')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Nous sommes ravis de vous accueillir sur Tikehub, la plateforme de billetterie en ligne pour l\'Afrique !')
            ->line('Votre compte a été créé avec succès en tant que **' . $roleText . '**.')
            ->line('**Que pouvez-vous faire maintenant ?**')
            ->when($role === 'organizer', function ($mail) {
                return $mail
                    ->line('• Créer et gérer vos événements')
                    ->line('• Organiser des concours')
                    ->line('• Lancer des collectes de fonds')
                    ->line('• Suivre vos ventes en temps réel');
            })
            ->when($role === 'buyer', function ($mail) {
                return $mail
                    ->line('• Découvrir des événements passionnants')
                    ->line('• Participer à des concours')
                    ->line('• Contribuer à des collectes de fonds')
                    ->line('• Gérer vos billets en un seul endroit');
            })
            ->action('Accéder à mon compte', route('dashboard'))
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
            //
        ];
    }
}
