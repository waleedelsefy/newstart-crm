<?php

namespace App\Providers;

use App\Events\LeadAssignedToUser;
use App\Models\Branch;
use App\Models\Lead;
use App\Observers\BranchObserver;
use App\Observers\LeadObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    protected $observers = [
        // User::class => [UserObserver::class],
        Branch::class => [BranchObserver::class],
        Lead::class => [LeadObserver::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // User::observe(UserObserver::class);

        // Event::listen(
        //     LeadAssignedToUser::class,
        // );

        // Event::listen(function (LeadAssignedToUser $event) {
        // });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
