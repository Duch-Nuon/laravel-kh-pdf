<?php

namespace KhmerPdfImg\LaravelKhPdfImg\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class PdfImgKhServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/kh-pdf-img.php', 'kh-pdf-img');
        $this->registerMPdf();
    }

    protected function registerMPdf()
    {
        $this->app->singleton('mPdf', function ($app) {

            $fontPathBattambang = __DIR__ . '/../Fonts/Battambang';
            $fontPathMoul = __DIR__ . '/../Fonts/Moul';

            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];


            return new \Mpdf\Mpdf(
                [

                'fontDir' => array_merge($fontDirs, [$fontPathBattambang, $fontPathMoul]),
                
                // https://mpdf.github.io/fonts-languages/fonts-in-mpdf-7-x.html

                'fontdata' => $fontData + [

                    'battambang' => [ // lowercase letters only in font key
                        'R' => 'Battambang-Regular.ttf',
                        'B' => 'Battambang-Bold.ttf',
                        'L' => 'Battambang-Light.ttf',
                        'useOTL' => 0xFF,
                    ],
                    'khmer-moul' => [ // lowercase letters only in font key
                        'R' => 'Moul-Regular.ttf',
                        'useOTL' => 0xFF,
                    ],
                ],

                'default_font' => config('kh-pdf-img.pdf.default_font', 'battambang'),
            ]);
        });
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