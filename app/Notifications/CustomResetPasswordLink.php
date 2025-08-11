<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class CustomResetPasswordLink extends ResetPassword
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $url = env('URL_TO_RESET_PASSWORD') . '?token=' . $this->token . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
                    ->subject('Restablecer tu contraseña')
                    ->line('Haz clic en el siguiente enlace para restablecer tu contraseña:')
                    ->action('Restablecer contraseña', $url)
                    ->line('Si no solicitaste un restablecimiento de contraseña, ignora este correo.');
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
