<?php

namespace App\Providers;

use App\Support\WindowsFilesystem;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (DIRECTORY_SEPARATOR !== '\\') {
            return;
        }

        $filesystem = new WindowsFilesystem();

        $this->app->instance('files', $filesystem);
        $this->app->instance(Filesystem::class, $filesystem);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
