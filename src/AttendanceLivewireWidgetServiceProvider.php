<?php

namespace Namratalohani\FilamentHrSystem;

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\ServiceProvider;
use Namratalohani\FilamentHrSystem\Filament\Widgets\AttendanceWidget;

class AttendanceLivewireWidgetServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/attendance.php', 'attendance');
    }

    public function boot()
    {
        // Publish configuration.
        $this->publishes([
            __DIR__.'/../config/attendance.php' => config_path('attendance.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/css/app.css' => public_path('vendor/attendance-widget/css/app.css'),
        ], 'attendance-assets');

        
        $this->publishes([
            __DIR__.'/../resources/css/filament/admin/theme.css' => public_path('vendor/attendance-livewire-widget/filament/admin/theme.css'),
        ], 'attendance-livewire-widget-assets');
        

        // Publish migrations.
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Register views.
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'attendance');

        // Register Filament widget.
        Filament::serving(function () {
            Filament::registerPanel(
                Panel::make()
                    ->viteTheme('resources/css/filament/admin/theme.css')
                    ->id('attendance')
                    ->path('admin')
                    ->widgets([
                        AttendanceWidget::class,
                    ])
            );
        });
    }
}
