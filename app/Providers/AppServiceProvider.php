<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;

use App\User;
use App\Observers\UserObserver;
use App\Bookings;
use App\Observers\ServiceBookingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);

        Schema::defaultStringLength(191);

        //User Model Events Observer
        User::observe(UserObserver::class);

        //Bookings Model Events Observer
        Bookings::observe(ServiceBookingObserver::class);
    }
}
