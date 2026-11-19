<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountActivationNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $token
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        $expire = config(
            'auth.passwords.'.config('auth.defaults.passwords').'.expire',
            60
        );

        return (new MailMessage)
            ->subject('Activa tu cuenta - EduGestión')
            ->greeting('¡Hola, '.$notifiable->name.'!')
            ->line('Se ha creado una cuenta estudiantil asociada a este correo electrónico.')
            ->line('Para comenzar a utilizar el portal de matrículas, debes establecer tu contraseña.')
            ->action('Activar mi cuenta', $url)
            ->line("Este enlace estará disponible durante {$expire} minutos.")
            ->line('Si no esperabas recibir este mensaje, puedes ignorarlo.');
    }
}