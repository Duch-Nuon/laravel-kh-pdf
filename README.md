# laravel-kh-pdf Package

This Laravel package integrates with mPDF to generate PDF documents containing Khmer text, support fonts khmer by Default.

## Installation

To install the package, run the following command:

```bash
composer require khmer-pdf/laravel-kh-pdf
```

## Available Method

 **loadHtml(string $html)**
 **download(string $filename)**
 **stream(string $filename)**
 **save(string $path, string $disk = 'public')**
 **addMPdfConfig(array $config)**

## Configure Fonts in the Package

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




