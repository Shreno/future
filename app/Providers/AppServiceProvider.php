<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;









class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {

         
        if (app()->environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
            }
        Schema::defaultStringLength(191);


   



    }

}
