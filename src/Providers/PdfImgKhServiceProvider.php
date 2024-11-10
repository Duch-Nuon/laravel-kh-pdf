<?php

namespace KhmerPdfImg\LaravelKhPdfImg\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class PdfImgKhServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/khPdfImg.php', 'khPdfImg');
        $this->registerMPdf();
    }

    protected function registerMPdf()
    {
        $this->app->singleton('mPdf', function ($app) {

            $fontPath = __DIR__ . '/../Fonts/KhmerOs';

            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];


            return new \Mpdf\Mpdf(
                [

                'fontDir' => array_merge($fontDirs, [$fontPath]),
                
                // https://mpdf.github.io/fonts-languages/fonts-in-mpdf-7-x.html

                'fontdata' => $fontData + [

                    'battambang' => [ // lowercase letters only in font key
                        'R' => 'KhmerOSbattambang.ttf',
                        'B' => 'KhmerOSniroth.ttf',
                        'useOTL' => 0xFF,
                    ],
                    'kh-moul' => [ // lowercase letters only in font key
                        'R' => 'KhmerOSmuol.ttf',
                        'useOTL' => 0xFF,
                    ],
                ],

                'default_font' => config('khPdfImg.pdf.default_font', 'khmer-r'),
            ]);
        });
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__.'/../config/khPdfImg.php' => config_path('khPdfImg.php'),
        ], 'khPdfImg');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishAssets();

            // Auto-publish if the config does not already exist
            if (!file_exists(config_path('khPdfImg.php'))) {
                Artisan::call('vendor:publish', [
                    '--tag' => 'khPdfImg',
                ]);
            }
        }
    }
}