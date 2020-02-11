<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\NewPayrollRegisterEvent::class => [
            \App\Listeners\SendPayrollRegisterListener::class,
        ],
        \App\Events\ResendEmployeeEmailEvent::class => [
            \App\Listeners\ResendEmployeeEmailListener::class,
        ],
        \App\Events\NewEmployeeEvent::class => [
            \App\Listeners\SendNewEmployeeEmailListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}