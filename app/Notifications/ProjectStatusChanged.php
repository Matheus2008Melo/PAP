<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $project;
    public $status;

    public function __construct($project, $status)
    {
        $this->project = $project;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = match($this->status) {
            'aprovado' => "O teu projeto '{$this->project->titulo}' foi aprovado!",
            'rejeitado' => "O teu projeto '{$this->project->titulo}' foi rejeitado. Verifica os motivos.",
            default => "O estado do teu projeto '{$this->project->titulo}' mudou para {$this->status}."
        };

        return [
            'title' => 'Atualização de Projeto',
            'message' => $message,
            'type' => $this->status === 'aprovado' ? 'success' : 'error',
            'link' => route('my-projects')
        ];
    }
}
