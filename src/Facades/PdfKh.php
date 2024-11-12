<?php

namespace KhmerPdf\LaravelKhPdf\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh loadHtml(string $html)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh download(string $filename)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh stream(string $filename)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh save(string $path, string $disk = 'public')
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh addMPdfConfig(array $config)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh watermarkText(string $text,float $opacity = 0.2,string $font = 'battambang',int $size = 100,int $angle = 45,string $color = '',array $config = [])
 */

class PdfKh extends Facade {
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
    {
        return 'pdfKh';
    }
}