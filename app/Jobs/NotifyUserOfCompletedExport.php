<?php

namespace App\Jobs;

use App\Helpers\Helper;
use App\Models\User;
use App\Notifications\ExportStatus;
use App\Notifications\GeneralNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NotifyUserOfCompletedExport implements ShouldQueue
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
                'en' => 'Exporting success',
                'ar' => 'نجحت عملية التصدير',
            ],
            'description' => [
                'en' => [
                    'You can download the file now from here',
                ],
                'ar' => [
                    'يمكنك تحميل الملف الأن من هنا'
                ]
            ],
            'icon' => 'feather icon-download-cloud',
            'url' => route('leads.export.download'),
            'color' => 'success',
        ];
        $this->user->notify(new GeneralNotification($options));
    }
}
