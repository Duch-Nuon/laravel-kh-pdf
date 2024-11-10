<?php

return [

    'pdf' => [
        /*
        |--------------------------------------------------------------------------
        | Default Font
        |--------------------------------------------------------------------------
        |
        | This sets the default font to be used in mPDF. You can specify a custom
        | font name if you want mPDF to use a specific font, such as a Khmer font.
        |
        */
        'default_font' => 'battambang',

        /*
        |--------------------------------------------------------------------------
        | Default Font Size
        |--------------------------------------------------------------------------
        |
        | Sets the default font size for the PDF. The default is 12pt, but you
        | can adjust this as needed.
        |
        */
        'default_font_size' => 12,

        /*
        |--------------------------------------------------------------------------
        | Temporary Directory
        |--------------------------------------------------------------------------
        |
        | Directory where mPDF stores temporary files, like large images and font caches.
        | Setting a custom tempDir in Laravel's storage is useful for permission management.
        |
        */
        'temp_dir' => storage_path('app/temp'),

        /*
        |--------------------------------------------------------------------------
        | PDF Page Size
        |--------------------------------------------------------------------------
        |
        | Sets the page size for the PDF. Common options are 'A4', 'A5', 'Letter', etc.
        | You can specify any size supported by mPDF.
        |
        */
        'page_size' => 'A4',

        /*
        |--------------------------------------------------------------------------
        | PDF Orientation
        |--------------------------------------------------------------------------
        |
        | Sets the orientation of the PDF pages. Options are 'P' for Portrait
        | and 'L' for Landscape.
        |
        */
        'orientation' => 'P',

        /*
        |--------------------------------------------------------------------------
        | Font Path and Custom Font Data
        |--------------------------------------------------------------------------
        |
        | Allows you to define custom fonts and font files. Add the font path
        | to load custom fonts stored within the project.
        |
        */
        // 'font_path' => public_path('fonts/'),
        // 'font_data' => [
        //     'battambang' => [ // lowercase letters only in font key
        //     'R' => 'KhmerOSbattambang.ttf',
        //     'B' => 'KhmerOSBattambang-Bold.ttf',
        //     'useOTL' => 0xFF,
            // ],
        // ],

    ],
];
