<?php

return [

        'pdf' => [
            'mode' => 'utf-8',
            'default_font' => 'battambang',
            'format'                => 'A4',
            'author'                => '',
            'subject'               => '',
            'keywords'              => '',
            'creator'               => 'Laravel Pdf',
            'display_mode'          => 'fullpage',
            'tempDir'               => storage_path('temp/mPdf'),
            'pdf_a'                 => false,
            'pdf_a_auto'            => false,
            // 'font_path' => public_path(''),
            // 'font_data' => [
            //     'khf1' => [
            //         'R'  => 'KHMERMEF1.ttf',    // regular font
            //         'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //     ],
            // ],
        ],

        'image' => [],
];