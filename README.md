# laravel-kh-pdf Package

This Laravel package integrates with mPDF to generate PDF documents containing Khmer text, support fonts khmer by Default.

## Installation

To install the package, run the following command:

```bash
composer require khmer-pdf/laravel-kh-pdf
```

## Configure Fonts in the Package

configure the font settings in the config/khPdf.php file. Here's how you can set it up:

Update font_path and font_data in config/khPdf.php:

```bash
'pdf' => [
    'default_font' => 'battambang', // Set your default font here

    // Path to the font files in your public directory
    'font_path' => public_path('fonts/'),

    'font_data' => [
        'battambang' => [
            'R' => 'KhmerOSbattambang.ttf',  // Regular font file
            'B' => 'KhmerOSBattambang-Bold.ttf',  // Bold font file
            'useOTL' => 0xFF, 
        ],
        'seamreap' => [
            'R' => 'KhmerOSbattambang.ttf',  // Regular font file
            'B' => 'KhmerOSBattambang-Bold.ttf',  // Bold font file
            'useOTL' => 0xFF,
        ],
    ],
],
```


