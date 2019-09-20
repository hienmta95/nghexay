<?php


return [

    /*
     |-----------------------------------------------------------------------------------------------
     | Default Logo
     |-----------------------------------------------------------------------------------------------
     |
     */

    'logo' => 'app/default/logo.png',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default Favicon
     |-----------------------------------------------------------------------------------------------
     |
     */

    'favicon' => 'app/default/ico/favicon.png',

    /*
     |-----------------------------------------------------------------------------------------------
     | Default ads picture & Default ads pictures sizes
     |-----------------------------------------------------------------------------------------------
     |
     */

    'picture' => [
        'default' => 'app/default/company.png',
        'size' => [
            'width'  => 1000,
            'height' => 1000,
        ],
		'quality' => env('PICTURE_QUALITY', 100),
        'resize' => [
            'logo'   => '500x100',
            'square' => '400x400', // ex: Categories
            'small'  => '120x90',
            'medium' => '320x240',
            'big'    => '816x460',
            'large'  => '1000x1000'
        ],
        'versioned' => env('PICTURE_VERSIONED', false),
        'version'   => env('PICTURE_VERSION', 1),
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Default user profile picture
     |-----------------------------------------------------------------------------------------------
     |
     */

    'photo' => '',

    /*
     |-----------------------------------------------------------------------------------------------
     | Countries SVG maps folder & URL base
     |-----------------------------------------------------------------------------------------------
     |
     */

    'maps' => [
        'path'    => public_path('images/maps') . '/',
        'urlBase' => 'images/maps/',
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Set as default language the browser language
     |-----------------------------------------------------------------------------------------------
     |
     */

    'detectBrowserLanguage' => false,

    /*
     |-----------------------------------------------------------------------------------------------
     | Optimize your URLs for SEO (for International website)
     |-----------------------------------------------------------------------------------------------
     |
     | You have to set the variables below in the /.env file:
     |
     | MULTI_COUNTRIES_URLS=true (to enable the multi-countries URLs optimization)
     | HIDE_DEFAULT_LOCALE_IN_URL=false (to show the default language code in the URLs)
     |
     */

	'multiCountriesUrls' => env('MULTI_COUNTRIES_URLS', false),

	/*
     |--------------------------------------------------------------------------
     | Force links to use the HTTPS protocol
     |--------------------------------------------------------------------------
     |
     */

	'forceHttps' => env('FORCE_HTTPS', true),

    /*
     |-----------------------------------------------------------------------------------------------
     | Plugins Path & Namespace
     |-----------------------------------------------------------------------------------------------
     |
     */

    'plugin' => [
        'path'      => app_path('Plugins') . '/',
        'namespace' => '\\App\Plugins\\',
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Managing User's Fields (Phone, Email & Username)
     |-----------------------------------------------------------------------------------------------
     |
     | When 'disable.phone' and 'disable.email' are TRUE,
     | the script use the email field by default.
     |
     */

    'disable' => [
        'phone'    => env('DISABLE_PHONE', false),
        'email'    => env('DISABLE_EMAIL', false),
        'username' => env('DISABLE_USERNAME', false),
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Disallowing usernames that match reserved names
     |-----------------------------------------------------------------------------------------------
     |
     */

    'reservedUsernames' => [
        'admin',
        'api',
        'profile',
        'fuck',
        'ditme',
        'hochiminh',
        'vonguyengiap',
        'nguyenphutrong',

        //...
    ],

    /*
     |-----------------------------------------------------------------------------------------------
     | Custom Prefix for the new locations (Administratives Divisions) Codes
     |-----------------------------------------------------------------------------------------------
     |
     */

    'locationCodePrefix' => 'Z',

    /*
     |-----------------------------------------------------------------------------------------------
     | Mile use countries (By default, the script use Kilometer)
     |-----------------------------------------------------------------------------------------------
     |
     */

    'mileUseCountries' => ['US','UK'],

	/*
     |-----------------------------------------------------------------------------------------------
     | MySQL Distance Calculation function (orthodromy or haversine formula)
     |-----------------------------------------------------------------------------------------------
     |
	 | e.g. orthodromy
     */

	'distanceCalculationFormula' => 'orthodromy',

	/*
     |-----------------------------------------------------------------------------------------------
     | Date & Datetime Format Syntax: http://php.net/strftime
	 | The implementation makes a call to strftime using the current instance timestamp.
     |-----------------------------------------------------------------------------------------------
     |
     */
	'defaultDateFormat'     => '%d %B %Y',
	'defaultDatetimeFormat' => '%d %B %Y %H:%M',
	'defaultTimezone'       => 'Asia/Ho_Chi_Minh',

	/*
     |-----------------------------------------------------------------------------------------------
     | Permalink Collection (Posts)
     |-----------------------------------------------------------------------------------------------
     |
     */

	'permalink' => [
		'posts' => [
			'{slug}-{id}' => ':slug-:id',
			'{slug}/{id}' => ':slug/:id',
			'{slug}_{id}' => ':slug_:id',
			'{id}-{slug}' => ':id-:slug',
			'{id}/{slug}' => ':id/:slug',
			'{id}_{slug}' => ':id_:slug',
			'{id}'        => ':id',
		],
	],

	/*
     |-----------------------------------------------------------------------------------------------
     | Maintenance Mode IP Whitelist
     |-----------------------------------------------------------------------------------------------
	 |
	 | e.g. ['127.0.0.1', '::1', '175.12.103.14', ...]
     |
     */

	'exceptOwnIp' => [
		//...
	],

	/*
     |-----------------------------------------------------------------------------------------------
     | During employer contacting, candidates can select a resume from their last 5 resumes.
	 | You can change this number to display more or less resumes during the selection
     |-----------------------------------------------------------------------------------------------
     |
     */

	'selectResumeInto' => 2,

	/*
     |-----------------------------------------------------------------------------------------------
     | Register process settings
     |-----------------------------------------------------------------------------------------------
     |
     */

	'register' => [
		'showCompanyFields' => env('REGISTER_SHOW_COMPANY_FIELDS', false), // Show/Hide Company fields from Registration Form depending of the User Type
		'showResumeFields'  => env('REGISTER_SHOW_RESUME_FIELDS', false), // Show/Hide Resume fields from Registration Form depending of the User Type
	],

];
