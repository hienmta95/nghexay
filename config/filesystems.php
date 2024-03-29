<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

	'default' => env('FILESYSTEM_DRIVER', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

	'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [
	
		'local' => [
			'driver' => 'local',
			'root' => storage_path('app'),
		],
	
		'public' => [
			'driver' 	 => 'local',
			'root' 		 => public_path('storage'),
			'url' 		 => env('STORAGE_URL'),
			'visibility' => 'public',
		],
		
		// To extend the script to accept cloud disks:
		// https://laravel.com/docs/master/filesystem#driver-prerequisites
		's3' => [
			'driver' => 's3',
			'key'    => env('S3_KEY', 'your-key'),
			'secret' => env('S3_SECRET', 'your-secret'),
			'region' => env('S3_REGION', 'your-region'),
			'bucket' => env('S3_BUCKET', 'your-bucket'),
			'url' 	 => env('S3_DISTRIBUTION_URL', ''),
		],
		
		// Used for Admin -> Log
        'storage' => [
            'driver' => 'local',
            'root'   => storage_path(),
        ],
		
		// Used for Admin -> Backup
        'backups' => [
            'driver' => 'local',
            'root'   => storage_path('backups'), // that's where your backups are stored by default: storage/backups
        ],

    ],

];
