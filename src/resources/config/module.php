<?php

return [
	'routes' => [
		[
			'prefix'     => 'api/auth',
			'middleware' => ['api'],
			'as' => '',
			'files'      => ['api']
		],
		[
			'prefix'     => 'auth',
			'middleware' => ['web'],
			'as' => '',
			'files'      => ['web']
		],
	],
];
