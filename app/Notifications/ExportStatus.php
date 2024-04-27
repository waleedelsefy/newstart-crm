<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportStatus extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 2;
    public $timeout = 10;

    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($status = 'success')
    {
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
        return [
            'title' => 'messages.export-' . $this->status,
            'icon' => 'feather icon-download-cloud',
            'link' => $this->status == 'success' ? route('leads.export.download') : null,
            'status' => $this->status,
            'image' => null,
            'color' => 'success',
        ];
    }
}
