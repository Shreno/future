<?php

namespace App\Listeners\SallaListeners;

use App\Events\SallaEvents\AppUninstalled;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppUninstalledListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AppUninstalled  $event
     * @return void
     */
    public function handle(AppUninstalled $event)
    {
        $merchant = User::where('provider_store_id', $event->webHookPayloadObject->merchant)->first();
        if(! is_null($merchant)){
            $merchant->update([
                'is_active' => 0
            ]);
        }
    }
}
