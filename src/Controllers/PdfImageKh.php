<?php

namespace KhmerPdfImg\LaravelKhPdfImg\Controllers;

use KhmerPdfImg\LaravelKhPdfImg\Traits\ImageKhTrait;
use KhmerPdfImg\LaravelKhPdfImg\Traits\PdfKhTrait;

class PdfImageKh
{
    public static function pdf(string $htmlContent)
    {
        $instance = new class{
            use PdfKhTrait;
        };

        return $instance->loadHtml($htmlContent);
    }

    public static function image(string $htmlContent)
    {
        $instance = new class{
            use ImageKhTrait;
        };

        return $instance->loadHtml($htmlContent);
    }
}