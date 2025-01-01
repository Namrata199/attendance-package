<?php

namespace Namratalohani\FilamentHrSystem;

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Namratalohani\FilamentHrSystem\Filament\Widgets\AttendanceWidget;

class FilamentHrSystemServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'filament-hr-system');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-hr-system');
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('filament-hr-system.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/filament-hr-system'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/filament-hr-system'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/filament-hr-system'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);

            // Register Filament widget.
            Filament::serving(function () {
                Filament::registerPanel(
                    Panel::make()
                        ->id('attendance')
                        ->path('admin')
                        ->widgets([
                            AttendanceWidget::class,
                        ])
                );
            });
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'filament-hr-system');

        // Register the main class to use with the facade
        $this->app->singleton('filament-hr-system', function () {
            return new FilamentHrSystem;
        });
    }
}
