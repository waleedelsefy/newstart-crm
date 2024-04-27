<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\LeadHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LeadToDelayAfter24h extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lead-to-delay-after-24h';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // (if have a reminder date) Make him delay after 24 hours from reminder date.
        Lead::whereNotNull('reminder')->whereNot('reminder', 'delay')->chunk(50, function ($leadsWithEventReminder) {
            foreach ($leadsWithEventReminder as $lead) {
                $reminderDateTimeAfter24H = Carbon::parse($lead->reminder_date)->addHours(24);

                if ($reminderDateTimeAfter24H < Carbon::now()) {
                    $lead->reminder = 'delay';
                    $lead->saveQuietly();

                    $lead->histories()->create([
                        'type' => 'event',
                        'info' => [
                            'en' => "No action was taken 24 hours after the date of the reminder added to an event [{$lead->event}][{$lead->reminder}]",
                            'ar' => "لم يتم اتخاذ اي اجراء بعد مرور 24 ساعة على تاريخ التذكير المضاف على حدث [{$lead->event}][{$lead->reminder}]"
                        ],
                        'user_id' => 1,
                        'notes' => NULL,
                        'event_id' => $lead->lastEvent()->event_id,
                        'previous_event' => $lead->lastEvent()->previous_event,
                        'reminder' => $lead->reminder,
                        'reminder_date' => $lead->reminder_date,
                    ]);
                }
            }
        });


        // $leadsWithEventReminder = Lead::whereNotNull('reminder')->whereNot('reminder', 'delay')->get();

        // foreach ($leadsWithEventReminder as $lead) {
        //     $reminderDateTimeAfter24H = Carbon::parse($lead->reminder_date)->addHours(24);

        //     if ($reminderDateTimeAfter24H < Carbon::now()) {
        //         $lead->reminder = 'delay';
        //         $lead->saveQuietly();

        //         $lead->histories()->create([
        //             'type' => 'event',
        //             'info' => [
        //                 'en' => "No action was taken 24 hours after the date of the reminder added to an event [{$lead->event}][{$lead->reminder}]",
        //                 'ar' => "لم يتم اتخاذ اي اجراء بعد مرور 24 ساعة على تاريخ التذكير المضاف على حدث [{$lead->event}][{$lead->reminder}]"
        //             ],
        //             'user_id' => 1,
        //             'notes' => NULL,
        //             'event_id' => $lead->lastEvent()->event_id,
        //             'previous_event' => $lead->lastEvent()->previous_event,
        //             'reminder' => $lead->reminder,
        //             'reminder_date' => $lead->reminder_date,
        //         ]);
        //     }
        // }

        // (if not have a reminder date) Make him delay after 24 hours from assigned date.

        // $leadsWithoutEventReminder = Lead::whereNull('reminder')->whereNotIn('event', ['fresh'])
        //     ->where('event_created_at', '<', Carbon::parse('-24 hours'))->get();

        $leadsWithoutEventReminder = Lead::where('event', 'no-action')->where('event_created_at', '<', Carbon::parse('-24 hours'))->get();

        foreach ($leadsWithoutEventReminder as $lead) {
            $lead->update(['reminder' => 'delay']);

            $lead->histories()->createQuietly([
                'type' => 'event',
                'info' => [
                    'en' => "No action was taken 24 hours after the assigned date to an event [{$lead->event}][{$lead->reminder}]",
                    'ar' => "لم يتم اتخاذ اي اجراء بعد مرور 24 ساعة على تاريخ التعيين على حدث [{$lead->event}][{$lead->reminder}]"
                ],
                'user_id' => 1,
                'notes' => NULL,
                'event_id' => $lead->lastEvent()->event_id,
                'previous_event' => $lead->lastEvent()->previous_event,
                'reminder' => $lead->reminder,
                'reminder_date' => $lead->reminder_date,
            ]);
        }
    }
}
