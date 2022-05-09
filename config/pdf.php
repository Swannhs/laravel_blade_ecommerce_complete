<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'font_path' => base_path('public/pdf_fonts/'),
	'font_data' => [
		'examplefont' => [
			'R'  => 'Poppins-Regular.ttf',    // regular font
			'B'  => 'Poppins-Regular.ttf',       // optional: bold font
			'I'  => 'Poppins-Regular.ttf',     // optional: italic font
			'BI' => 'Poppins-Regular.ttf' // optional: bold-italic font
			//'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			//'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
];
