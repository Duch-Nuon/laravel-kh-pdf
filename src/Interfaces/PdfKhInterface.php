<?php

namespace KhmerPdf\LaravelKhPdf\Interfaces;

interface PdfKhInterface
{
    public function loadHtml(string $html);
    public function download(string $filename);
    public function stream(string $filename);
    public function save(string $path, string $disk = 'public');
    public function addMPdfConfig($config = []);
    public function watermarkText(
        string $text, 
        float $opacity = 0.2, 
        string $font = 'khmeros',
        int $size = 100,
        int $angle = 45,
        string $color = '',
        array $config = []
    );
    public function watermarkImage(
        string $path,
        string|int|array $size  = 'p',
        string|array $position = 'p',
        float $opacity = 1,
        bool $behindContent = false,
        array $config = []
    );
    public function writeBarcode(
        string $code,
        int $horizontal,
        int $vertical,
        bool $showIsbn = true,
        int $size = 1,
        bool $border = true
    );
}
