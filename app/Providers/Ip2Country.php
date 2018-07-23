<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class Ip2Country extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(\App\Services\Ip2Country::class, function ($app) {
            $service = config('services.ip2country');
            $inst = $service['resolver'];
            $config = $service['config'];
            return new $inst($config);
        });
    }
}
