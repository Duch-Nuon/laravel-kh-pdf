# laravel-kh-pdf Package


<!-- ![License](https://poser.pugx.org/vendor/package-name/license) -->
![Latest Stable Version](https://github.com/Duch-Nuon/laravel-kh-pdf/v/1.0.0)
![Total Downloads](https://github.com/Duch-Nuon/laravel-kh-pdf/downloads)

This Laravel package integrates with mPDF to generate PDF documents containing Khmer text, support fonts khmer by Default.

## Installation

To install the package, run the following command:

```bash
composer require khmer-pdf/laravel-kh-pdf
```

## Basic Usage:


```php
<?php
use Illuminate\Support\Facades\Route;
use KhmerPdf\LaravelKhPdf\Facades\PdfKh;
Route::get('/', function () {
    $view = view('test-font')->render();
    $pdf = PdfKh::loadHtml($view)->stream('test.pdf');            
    return $pdf;
});
```
```php
use Illuminate\Support\Facades\Route;
use KhmerPdf\LaravelKhPdf\Facades\PdfKh;
Route::get('/', function () {
    $view = view('test-font')->render();
    $pdf = PdfKh::loadHtml($view)->addMPdfConfig(['format' => 'A5',])->stream('test.pdf');       
    return $pdf;
});
```

## Available Method

 **loadHtml(string $html)**

 **download(string $filename)**

 **stream(string $filename)**

 **save(string $path, string $disk = 'public')**

 **addMPdfConfig(array $config)**

For more options config: **addMPdfConfig(array $config)**

An associative array containing configuration options. For a list of available options, refer to mPDF Configuration Options.

https://mpdf.github.io/reference/mpdf-variables/overview.html

## Example
   ```php
   addMPdfConfig(['format' => 'A5-L',]);
   ```

## Setup & Configuration

This guide will show you how to configure the Khmer fonts in the `config/khPdf.php` file for PDF generation using `khPdf`. By default, the Khmer fonts **KhmerOSBattambang**, **KhmerOS** and **KhmerOSMuol** are supported.
You can more fonts.
```php
'pdf' => [
    'default_font' => 'battambang', // Set your default font here

    // Path to the font files in your public directory
    'font_path' => public_path('fonts/'),

    'font_data' => [
        'battambang' => [ // lowercase letters only in font key
            'R' => 'KhmerOSbattambang.ttf',
            'B' => 'KhmerOSBattambang-Bold.ttf',
            'useOTL' => 0xFF,
        ],
        'khmermuol' => [ // lowercase letters only in font key
            'R' => 'KhmerOSmuol.ttf',
            'useOTL' => 0xFF,
        ],
    ],
],
```
`test-font.blade.php`
```html
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
```




