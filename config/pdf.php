<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A2',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Sensors',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
//    'font_path' => storage_path('app/public/fonts/'),
    'font_path' => storage_path('app/public/fonts/'),'font_data' => [
        'examplefont' => [
            'R'  => 'arial-bold.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,// regular font
        ]
        // ...add as many as you want.
    ]
    // ...
];
