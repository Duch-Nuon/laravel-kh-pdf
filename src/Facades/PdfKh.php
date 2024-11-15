<?php

namespace KhmerPdf\LaravelKhPdf\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KhmerPdf\LaravelKhPdf\Controllers\PdfKh loadHtml(string $html)
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