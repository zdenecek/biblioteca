<?php

namespace App\Providers;

use App\Events\BookBorrowed;
use App\Listeners\LibraryLogger;
use App\Listeners\ValidateUserOnBorrow;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        BookBorrowed::class => [
            ValidateUserOnBorrow::class
        ]
    ];

    protected $subscribe = [
        LibraryLogger::class
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
