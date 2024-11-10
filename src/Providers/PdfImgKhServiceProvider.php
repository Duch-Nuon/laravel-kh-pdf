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
            $fontPathConfig = config('khPdfImg.pdf.font_path');

            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $fontDataConfig = config('khPdfImg.pdf.font_data', []);

            return new \Mpdf\Mpdf(
                [

                'default_font' => config('khPdfImg.pdf.default_font', 'battambang'),
                'default_font_size' => config('khPdfImg.pdf.default_font_size', 12),
                'tempDir' => config('khPdfImg.pdf.temp_dir', storage_path('temp')),
                'format' => config('khPdfImg.pdf.page_size', 'A4'),
                'orientation' => config('khPdfImg.pdf.orientation', 'P'),

                'fontDir' => array_merge($fontDirs, [$fontPath, $fontPathConfig]),
                
                // https://mpdf.github.io/fonts-languages/fonts-in-mpdf-7-x.html

                'fontdata' => $fontData + [

                    'battambang' => [ // lowercase letters only in font key
                        'R' => 'KhmerOSbattambang.ttf',
                        'B' => 'KhmerOSBattambang-Bold.ttf',
                        'useOTL' => 0xFF,
                    ],
                    'kh-moul' => [ // lowercase letters only in font key
                        'R' => 'KhmerOSmuol.ttf',
                        'useOTL' => 0xFF,
                    ],

                ] + $fontDataConfig,

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