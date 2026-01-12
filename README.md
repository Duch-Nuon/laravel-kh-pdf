# laravel-kh-pdf

[![Latest Stable Version](https://poser.pugx.org/khmer-pdf/laravel-kh-pdf/v/stable)](https://packagist.org/packages/khmer-pdf/laravel-kh-pdf)
[![Total Downloads](https://poser.pugx.org/khmer-pdf/laravel-kh-pdf/downloads)](https://packagist.org/packages/khmer-pdf/laravel-kh-pdf)
[![License](https://poser.pugx.org/khmer-pdf/laravel-kh-pdf/license)](https://choosealicense.com/licenses/mit/)

Laravel PDF with Khmer Font Support using mPDF.

# Laravel Khmer PDF

Laravel Khmer PDF is a package designed to simplify PDF generation in Laravel with built-in support for Khmer fonts. It integrates seamlessly with mPDF to create professional-looking PDFs.

## Installation

Install the package via Composer:

```bash
composer require khmer-pdf/laravel-kh-pdf
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=khPdf
```

This will create a `config/khPdf.php` file where you can customize font settings and mPDF configurations.

## Usage

### Run command to generate demo 
```bash
php artisan khPdf:demo
```
### Follow the route url
```bash
php artisan serve
```
```bash
http://localhost:8000/kh-pdf-test
```
### Basic PDF Generation

Use the `PdfKh` facade to generate PDFs:

```php
use KhmerPdf\LaravelKhPdf\Facades\PdfKh;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $html = view('pdf.template', ['title' => 'សួស្តី ពិភពលោក!'])->render();
        return PdfKh::loadHtml($html)->download('khmer_document.pdf');
    }
}
```

## Methods

The trait provides the following methods:

| Method                                                                       | Description                                        | Example                                                                         |
| ---------------------------------------------------------------------------- | -------------------------------------------------- | ------------------------------------------------------------------------------- |
| `loadHtml($html)`                                                            | Sets the HTML content for the PDF.                 | `PdfKh::loadHtml(view('pdf.template')->render());`                              |
| `download($filename)`                                                        | Prompts the browser to download the generated PDF. | `PdfKh::download('file.pdf');`                                                  |
| `stream($filename)`                                                          | Displays the PDF directly in the browser.          | `PdfKh::stream('file.pdf');`                                                    |
| `save($path, $disk)`                                                         | Saves the PDF to the specified storage disk.       | `PdfKh::save('pdfs/report.pdf', 'public');`                                     |
| `addMPdfConfig($config)`                                                     | Adds custom mPDF configuration settings.           | `PdfKh::addMPdfConfig(['mode' => 'utf-8', 'format' => 'A4-L']);`                |
| `watermarkText($text, $opacity, $font, $size, $angle, $color, $config)`      | Adds a text watermark to the PDF.                  | `PdfKh::watermarkText('Confidential', 0.2, 'khmeros', 100, 45, '#FF0000', []);` |
| `watermarkImage($path, $size, $position, $opacity, $behindContent, $config)` | Adds an image watermark to the PDF.                | `PdfKh::watermarkImage('path/to/image.png', 'p', 'p', 1, false, []);`           |
| `writeBarcode($code, $horizontal, $vertical, $showIsbn, $size, $border)`     | Writes a barcode in the PDF.                       | `PdfKh::writeBarcode('123456789', 10, 10, true, 1, true);`                      |

### Examples

`template.blade.php`
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

#### Adding custom mPDF Config

You can configure mPDF settings using the `addMPdfConfig` method:

```php
public function generateCustomPdf()
{
    $html = view('pdf.template', ['title' => 'Custom PDF'])->render();
    PdfKh::loadHtml($html)->addMPdfConfig([
        'mode' => 'utf-8',
        'format' => 'A4-L',
        'margin_top' => 10,
        'margin_bottom' => 10
    ])->download('custom_config.pdf');
}
```

#### Saving a PDF

```php
public function savePdf()
{
    $html = view('pdf.template', ['title' => 'Report'])->render();
    $path = PdfKh::loadHtml($html)->save('pdfs/report.pdf', 'public');
    return response()->json(['pdf_url' => asset('storage/' . $path)]);
}
```

#### Streaming a PDF

```php
public function streamPdf()
{
    $html = view('pdf.template', ['title' => 'Live Preview'])->render();
    return PdfKh::loadHtml($html)->stream('live_preview.pdf');
}
```

#### Adding a Text Watermark

```php
public function watermarkPdf()
{
    $html = view('pdf.template', ['title' => 'Secret Document'])->render();
    return PdfKh::loadHtml($html)->watermarkText('Confidential', 0.2, 'khmeros', 100, 45, '#FF0000')->download('watermarked.pdf');
}
```

#### Adding an Image Watermark

```php
public function watermarkImagePdf()
{
    $html = view('pdf.template', ['title' => 'Image Watermark'])->render();
    return PdfKh::loadHtml($html)->watermarkImage('path/to/image.png', 'p', 'p', 1, false)->download('image_watermarked.pdf');
}
```

#### Adding a Barcode

```php
public function barcodePdf()
{
    $html = view('pdf.template', ['title' => 'Barcode PDF'])->render();
    return PdfKh::loadHtml($html)->writeBarcode('123456789', 10, 10, true, 1, true)->download('barcode.pdf');
}
```

## Configuration

The `khPdf.php` config file allows you to adjust font paths, default styles, and mPDF options.

Example:

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

## License

This package is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributions

Contributions are welcome! Feel free to submit pull requests or issues on the [GitHub repository](https://github.com/Duch-Nuon/laravel-kh-pdf).





