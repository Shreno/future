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
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\SallaEvents\OrderShipmentCreating' => [
            'App\Listeners\SallaListeners\OrderShipmentCreatingListener',
        ],
        'App\Events\SallaEvents\OrderShipmentReturnCreating' => [
            'App\Listeners\SallaListeners\OrderShipmentReturnCreatingListener',
        ],
        'App\Events\SallaEvents\AppStoreAuthorize' => [
            'App\Listeners\SallaListeners\AppStoreAuthorizeListener',
        ],
        'App\Events\SallaEvents\AppUninstalled' => [
            'App\Listeners\SallaListeners\AppUninstalledListener',
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
