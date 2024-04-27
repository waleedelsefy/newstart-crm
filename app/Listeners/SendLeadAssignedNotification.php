<?php

namespace App\Listeners;

use App\Events\LeadAssignedToUser;
use App\Models\Lead;
use App\Notifications\GeneralNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLeadAssignedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(LeadAssignedToUser $event): void
    {
        $lead = $event->lead;
        $assignedTo = $lead->assignedTo;

        $options = [
            'title' => [
                'en' => 'You have been assigned a new client',
                'ar' => 'لقد تم تعيين لك عميل جديد',
            ],
            'description' => [
                'en' => [
                    'You can see the details here',
                ],
                'ar' => [
                    'يمكنك مشاهدة التفاصيل من هنا'
                ]
            ],
            // 'icon' => 'feather icon-download-cloud',
            'image' => $assignedTo->getPhoto(),
            'url' => route('leads.index'),
            'color' => 'primary',
        ];

        $assignedTo->notify(new GeneralNotification($options));
    }
}
