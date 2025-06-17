<?php

namespace Pekhota\NovaHugeRTE;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event) {
            Nova::mix('nova-hugerte', __DIR__.'/../dist/mix-manifest.json');
        });

        $this->publishes([
            __DIR__.'/../config/nova-hugerte.php' => config_path('nova-hugerte.php'),
        ], 'config');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
