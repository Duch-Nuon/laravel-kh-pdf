<?php

namespace KhmerPdf\LaravelKhPdf\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PdfDemoCommand extends Command
{
    protected $signature = 'khPdf:demo';
    protected $description = 'Auto-create demo Blade file and test route for KhPdf';

    public function handle()
    {
        $this->info('Setting up KhPdf demo Blade and route...');

        $bladePath = resource_path('views/khPdf_test.blade.php');

        // add demo blade file
        if (!File::exists($bladePath)) {
            $bladeContent = <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <style>
                        p{
                            font-size: 25px;
                            /* font-family: 'battambang';
                            font-weight: bold; */

                            font-family: 'khmermuol';
                        }
                    </style>
                </head>
                <body>
                    <p>សួស្តី ​ពិភពលោក ! Hello World</p>
                </body>
                </html>
                HTML;
            File::put($bladePath, $bladeContent);
            $this->info("Blade file created at: resources/views/khpdf_test.blade.php");
        } else {
            $this->info("Blade file already exists: resources/views/khpdf_test.blade.php");
        }

        // add demo route
        $routeFile = base_path('routes/web.php');
        $routeContent = <<<PHP
            \n
            Route::get('/kh-pdf-test', function () {
                \$html = view('khPdf_test', ['title' => 'សួស្តី ពិភពលោក!'])->render();
                return KhmerPdf\LaravelKhPdf\Facades\PdfKh::loadHtml(\$html)->stream('khmer_document.pdf');
            });

            PHP;

        if (File::exists($routeFile)) {
            File::append($routeFile, $routeContent);
            $this->info("Demo route added: <fg=cyan>http://localhost:8000/kh-pdf-test</>");
        } else {
            $this->error("routes/web.php not found. Add route manually.");
        }

        $this->info('Setup complete! You can now test with php artisan kh-pdf:test or visit /kh-pdf-test.');
    }
}
