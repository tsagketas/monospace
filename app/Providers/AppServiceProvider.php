<?php

namespace App\Providers;

use App\Models\Vessel;
use App\Models\Voyage;
use Illuminate\Support\ServiceProvider;
use App\Observers\VesselObserver;
use App\Observers\VoyageObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Vessel::observe(VesselObserver::class);
        Voyage::observe(VoyageObserver::class);
    }
}
