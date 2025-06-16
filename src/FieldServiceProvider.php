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
            Nova::mix('hugerte-editor', __DIR__.'/../dist/mix-manifest.json');
        });

        $this->publishes([
            __DIR__.'/../config/nova-hugerte-editor.php' => config_path('nova-hugerte-editor.php'),
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
