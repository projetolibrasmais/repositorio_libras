<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserInvitation extends Notification
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
        // Generate password reset token
        $token = Str::random(64);
        
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $notifiable->email],
            [
                'email' => $notifiable->email,
                'token' => bcrypt($token),
                'created_at' => now()
            ]
        );

        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Convite - Repositório Libras+')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Você foi convidado para fazer parte do sistema Repositório Libras+.')
            ->line('Para começar a utilizar o sistema, você precisa definir sua senha de acesso.')
            ->action('Definir Senha', $url)
            ->line('Este link de convite expirará em 60 minutos.')
            ->line('Se você não esperava receber este convite, nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Equipe Repositório Libras+');
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
