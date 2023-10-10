<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Liberary\Settings;

class SettingServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['*'], Settings::class);
    }
}
