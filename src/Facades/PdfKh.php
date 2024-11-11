<?php

namespace KhmerPdf\LaravelKhPdf\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh loadHtml(string $html)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh download(string $filename)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh stream(string $filename)
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh save(string $path, string $disk = 'public')
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh addMPdfConfig(array $config)
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