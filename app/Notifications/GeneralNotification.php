<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 2;
    public $timeout = 10;
    public $supportedLocales = [];
    public $options = [];

    /**
     * Create a new notification instance.
     */
    public function __construct(array $options)
    {
        $this->supportedLocales = config('laravellocalization.supportedLocales');

        $this->options = [
            'sendVia' => ['database'],
            'title' => [],
            'description' => [],
            'icon' => 'feather icon-bell',
            'image' => null,
            'buttonText' => null,
            'url' => null,
            'color' => 'dark',
            'moreOptions' => [],
            ...$options,
        ];

        foreach ($this->supportedLocales as $locale => $localeData) {
            if ($this->options['description'] && $this->options['description'][$locale]) {
                $this->options['inlineContent'][$locale] = implode("\n", $options['description'][$locale]);
            }
        }

        /**
         * Example of translateable notification
         */

        // $options = [
        //     'title' => [
        //         'en' => 'Exporting fail',
        //         'ar' => 'فشلت عملية التصدير',
        //     ],
        //     'description' => [
        //         'en' => [
        //             'Please try again',
        //         ],
        //         'ar' => [
        //             'يرجى اعادة المحاول مرة اخرى'
        //         ]
        //     ],
        //     'icon' => 'feather icon-download-cloud',
        //     'url' => route('leads.index'),
        //     'color' => 'danger',
        // ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return $this->options['sendVia'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__($this->options['title']))
            ->line($this->options['inlineContent'])
            ->action(__($this->options['buttonText']), $this->options['url']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->options['title'],
            'description' => $this->options['description'],
            'inlineContent' => $this->options['inlineContent'],
            'icon' => $this->options['icon'],
            'image' => $this->options['image'],
            'url' => $this->options['url'],
            'color' => $this->options['color'],
            ...$this->options['moreOptions']
        ];
    }
}
