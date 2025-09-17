<?php

namespace App\Providers;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Filament\Events\ServingFilament;
use Filament\Support\Assets\Js;

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


public function boot(): void
{
    \Filament\Facades\Filament::serving(function (ServingFilament $event) {
        FilamentAsset::register([
            new Js('https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js'),
        ]);
    });
}
}
