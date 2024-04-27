<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\GeneralNotification;
use App\Notifications\ImportStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $options = [
            'title' => [
                'en' => 'Importing success',
                'ar' => 'نجحت عملية الاستراد',
            ],
            'description' => [
                'en' => [
                    'You can see the new data now from here',
                ],
                'ar' => [
                    'يمكنك مشاهدة البيانات الجديدة من هنا'
                ]
            ],
            'icon' => 'feather icon-upload-cloud',
            'url' => route('leads.index'),
            'color' => 'success',
        ];

        $this->user->notify(new GeneralNotification($options));
    }
}
