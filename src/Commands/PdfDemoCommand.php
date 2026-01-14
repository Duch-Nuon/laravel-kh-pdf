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
        $this->newLine();
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║           KhPdf Demo Setup - Configuration Wizard            ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->newLine();

        $bladePath = resource_path('views/khPdf_test.blade.php');

        // Create demo blade file
        $this->line('  <fg=yellow>→</> Creating demo Blade file...');
        
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
                    <p>សួស្តី ពិភពលោក ! Hello World</p>
                </body>
                </html>
                HTML;
            File::put($bladePath, $bladeContent);
            $this->line("     <fg=green>✓</> Blade file created successfully");
        } else {
            $this->line("     <fg=blue>ℹ</> Blade file already exists");
        }
        
        $this->line("     <fg=gray>Location:</> <fg=cyan>resources/views/khPdf_test.blade.php</>");

        $this->newLine();

        // Add demo route
        $routeFile = base_path('routes/web.php');
        
        $this->line('  <fg=yellow>→</> Adding demo route...');
        
        $routeContent = <<<PHP
            \n
            Route::get('/kh-pdf-test', function () {
                \$html = view('khPdf_test', ['title' => 'សួស្តី ពិភពលោក!'])->render();
                return KhmerPdf\LaravelKhPdf\Facades\PdfKh::loadHtml(\$html)->stream('khmer_document.pdf');
            });

            PHP;

        if (File::exists($routeFile)) {
            File::append($routeFile, $routeContent);
            $this->line("     <fg=green>✓</> Route added successfully");
            $this->line("     <fg=gray>Route:</> <fg=cyan>GET /kh-pdf-test</>");
        } else {
            $this->line("     <fg=red>✗</> routes/web.php not found");
            $this->warn('     Please add the route manually to your routes file.');
        }

        $this->newLine();
        $this->info('─────────────────────────────────────────────────────────────');
        $this->line('  <fg=green;options=bold>✓ Setup Complete!</>');
        $this->info('─────────────────────────────────────────────────────────────');
        $this->newLine();

        $this->comment('Next Steps:');
        $this->line('  1. Start your server: <fg=yellow>php artisan serve</>');
        $this->line('  2. Visit: <fg=cyan;options=bold>http://localhost:8000/kh-pdf-test</>');
        
        $this->newLine();
    }
}