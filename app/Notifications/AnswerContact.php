<?php

namespace App\Notifications;

use App\Models\Contato;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnswerContact extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Contato $contato, private string $resposta)
    {
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
        return (new MailMessage)
            ->subject('Resposta ao seu contato - Plataforma Digital Libras+')
            ->view('emails.answer-contact', [
                'userName' => $this->contato->nome,
                'mensagem' => $this->contato->mensagem,
                'resposta' => $this->resposta,
            ]);
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
