<?php

namespace Pekhota\NovaHugeRTE;

use Composer\InstalledVersions;
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
//            $ver = InstalledVersions::getPrettyVersion('pekhota/nova-hugerte') ?? time();
            $ver = filemtime(__DIR__.'/../dist/js/field.js') ?: time();

            Nova::script('nova-hugerte', __DIR__."/../dist/js/tool.js?v={$ver}");
            Nova::style('nova-hugerte', __DIR__."/../dist/css/tool.css?v={$ver}");
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
