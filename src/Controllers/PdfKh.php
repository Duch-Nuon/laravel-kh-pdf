<?php

namespace KhmerPdf\LaravelKhPdf\Controllers;

use KhmerPdf\LaravelKhPdf\Traits\PdfKhTrait;

class PdfKh
{
    public static function pdf(string $htmlContent)
    {
        $instance = new class{
            use PdfKhTrait;
        };

        return $instance->loadHtml($htmlContent);
    }
}