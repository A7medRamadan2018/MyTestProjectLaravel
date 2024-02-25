<?php

namespace App\Providers;

use App\Events\SellerRegisteredEvent;
use App\Events\SellerRegisteringEvent;
use App\Listeners\SendNotifictaionToAdmins;
use App\Listeners\SendRegisteredSellerNotifictaionToAdmins;
use App\Listeners\SendRegisteringSellerNotifictaionToAdmins;
use App\Models\Seller;
use App\Observers\SellerObserver;
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
        SellerRegisteringEvent::class => [
            SendRegisteringSellerNotifictaionToAdmins::class,
        ],
        SellerRegisteredEvent::class => [
            SendRegisteredSellerNotifictaionToAdmins::class,
        ],
    ];

    // protected $observers = [
    //     Seller::class => [SellerObserver::class],
    // ];
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
