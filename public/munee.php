<?php
// Include the composer autoload file
require 'vendor/autoload.php';
// Echo out the response
//echo getcwd();die;
if(!defined('WEBROOT')){
    define('WEBROOT',getcwd());
}
if(!defined('WEBROOT')) {
    define('WEBROOT', getcwd() . DS . '/cache');
}

echo \Munee\Dispatcher::run(new \Munee\Request([
    'checkReferrer' => false,
    'image' => [
        'checkReferrer' => false,
        'numberOfAllowedFilters' => 5,
        'placeholders' => [
            '*' =>  WEBROOT . DS . 'images' . DS . 'blank.gif'
        ]
    ]
]));
