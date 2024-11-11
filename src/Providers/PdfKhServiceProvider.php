<?php

namespace KhmerPdf\LaravelKhPdf\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use KhmerPdf\LaravelKhPdf\Controllers\PdfKh;

class PdfKhServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/khPdf.php', 'khPdf');
        $this->registerMPdf();

        $this->app->singleton('pdfKh', function ($app) {
            return new PdfKh();
        });
    }

    protected function registerMPdf()
    {
        $this->app->singleton('mPdf', function ($app, $config) {

            $fontPath = __DIR__ . '/../Fonts/KhmerOs';
            $fontPathConfig = config('khPdf.pdf.font_path');

            $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
            $fontDataConfig = config('khPdf.pdf.font_data', []);

            $mPdfConfig =   [

                'default_font' => config('khPdf.pdf.default_font', 'battambang'),
                'default_font_size' => config('khPdf.pdf.default_font_size', 12),
                'tempDir' => config('khPdf.pdf.temp_dir', storage_path('app/temp')),
                'format' => config('khPdf.pdf.page_size', 'A4'),
                'orientation' => config('khPdf.pdf.orientation', 'P'),

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
            ];

            if($config){
                $mPdfConfig = array_merge($mPdfConfig, $config);
            }

            return new \Mpdf\Mpdf($mPdfConfig);
        });
    }

    protected function publishAssets(): void
    {
        $this->publishes([
            __DIR__.'/../config/khPdf.php' => config_path('khPdf.php'),
        ], 'khPdf');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishAssets();

            // Auto-publish if the config does not already exist
            if (!file_exists(config_path('khPdf.php'))) {
                Artisan::call('vendor:publish', [
                    '--tag' => 'khPdf',
                ]);
            }
        }
    }
}