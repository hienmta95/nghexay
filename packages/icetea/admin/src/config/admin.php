<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
    */

    // The prefix used in all base routes (the 'admin' in admin/dashboard)
    'route_prefix' => 'admin',


    /*
     |--------------------------------------------------------------------------
     | ADMIN - Look & feel customizations
     |--------------------------------------------------------------------------
     |
     */

    // Project name. Shown in the breadcrumbs and a few other places.
    'project_name' => 'Golden Careers',

    // Menu logos
    'logo_lg'   => '<b>Golden </b>Careers',
    'logo_mini' => '<b>Golden Careers</b>',

    // Developer or company name. Shown in footer.
    'developer_name' => 'Golden Careers',

    // Developer website. Link in footer.
    'developer_link' => 'http://iceteastudio.com',

    // Show powered by Laravel in the footer?
    'show_powered_by' => true,

    // The AdminLTE skin. Affects menu color and primary/secondary colors used throughout the application.
    'skin' => 'skin-purple',
    // Options: skin-black, skin-blue, skin-purple, skin-red, skin-yellow, skin-green, skin-blue-light, skin-black-light, skin-purple-light, skin-green-light, skin-red-light, skin-yellow-light

    // Date & Datetime Format Syntax: https://github.com/jenssegers/date#usage
    // (same as Carbon)
    'default_date_format'     => 'j F Y',
    'default_datetime_format' => 'j F Y H:i',

    // Admin toggle navigation
    'toggle_navigation' => 'Toggle Navigation',

    // How many items should be shown by default by the Datatable?
    'default_page_length' => 25,
	
	// Where do you want to redirect the user by default, after a CRUD entry is saved in the Add or Edit forms?
	'default_save_action' => 'save_and_back', // options: save_and_back, save_and_edit, save_and_new


    /*
    |--------------------------------------------------------------------------
    | Registration Open
    |--------------------------------------------------------------------------
    |
    | Choose wether new users are allowed to register.
    | This will show up the Register button in the menu and allow access to the
    | Register functions in AuthController.
    |
    */

    'registration_open' => false,



    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    */

    // Fully qualified namespace of the User model
    'user_model_fqn' => '\App\Models\User',

];
