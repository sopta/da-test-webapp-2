<?php

declare(strict_types=1);

namespace CzechitasApp\Providers;

use CzechitasApp\Listeners\MailLog\SaveSentMailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<string, array<string>>
     */
    protected $listen = [
        MessageSent::class => [
            SaveSentMailListener::class,
        ],

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];
}
