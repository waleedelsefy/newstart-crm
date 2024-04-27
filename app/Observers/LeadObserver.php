<?php

namespace App\Observers;

use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\User;
use Illuminate\Support\Facades\Blade;

class LeadObserver
{

    public function creating(Lead $lead): void
    {
        $lead->created_by = $lead->created_by ?? auth()->id();
        $lead->event_created_at = now();
    }
    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        $user = auth()->user();

        /**
         * In case that lead was created by importing excel sheet by ImportJob::class
         * in that case there's no auth user
         */
        if (!$user)
            $user = User::owners()->first();

        $userLink = Blade::render(
            '<a href="{{route("users.show", $user)}}">{{$user->name}}</a>',
            compact("user")
        );

        $leadLink = Blade::render(
            '<a href="{{route("leads.show", $lead)}}">{{$lead->name}}</a>',
            compact("lead")
        );

        $lead->histories()->create([
            'type' => 'created',
            'info' => [
                'en' => "{$userLink} added the lead {$leadLink}",
                'ar' => "قام {$userLink} بإضافة العميل {$leadLink}"
            ],
            'user_id' => $user->id,
            'notes' => $lead->notes,
        ]);
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        $lead->phones()->delete();
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        //
    }
}
