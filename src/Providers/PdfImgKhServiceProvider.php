<?php

namespace KhmerPdfImg\LaravelKhPdfImg\Providers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use KhmerPdfImg\LaravelKhPdfImg\Controllers\PdfImgKhController;

class PdfImgKhServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/kh-pdf-img.php', 'kh-pdf-img');
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__.'/../config/kh-pdf-img.php' => config_path('kh-pdf-img.php'),
        ], 'kh-pdf-img');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishAssets();

            // Auto-publish if the config does not already exist
            if (!file_exists(config_path('kh-pdf-img.php'))) {
                Artisan::call('vendor:publish', [
                    '--tag' => 'kh-pdf-img',
                ]);
            }
        }
    }
}