<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1af4bf5e18a24ae696337a5c4440f667
{
    public static $files = array (
        '52e181473ddd523a649d74860143e341' => __DIR__ . '/..' . '/meenie/javascript-packer/class.JavaScriptPacker.php',
        'd1844434c6ccf07ad210a354fcf424ea' => __DIR__ . '/..' . '/meenie/munee/config/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Munee\\' => 6,
        ),
        'L' => 
        array (
            'Leafo\\ScssPhp\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Munee\\' => 
        array (
            0 => __DIR__ . '/..' . '/meenie/munee/src/Munee',
        ),
        'Leafo\\ScssPhp\\' => 
        array (
            0 => __DIR__ . '/..' . '/leafo/scssphp/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Sabberworm\\CSS' => 
            array (
                0 => __DIR__ . '/..' . '/sabberworm/php-css-parser/lib',
            ),
        ),
        'L' => 
        array (
            'Less' => 
            array (
                0 => __DIR__ . '/..' . '/oyejorge/less.php/lib',
            ),
        ),
        'J' => 
        array (
            'JShrink' => 
            array (
                0 => __DIR__ . '/..' . '/tedivm/jshrink/src',
            ),
        ),
        'I' => 
        array (
            'Imagine' => 
            array (
                0 => __DIR__ . '/..' . '/imagine/imagine/lib',
            ),
        ),
        'C' => 
        array (
            'CoffeeScript' => 
            array (
                0 => __DIR__ . '/..' . '/coffeescript/coffeescript/src',
            ),
        ),
    );

    public static $classMap = array (
        'CSSmin' => __DIR__ . '/..' . '/tubalmartin/cssmin/cssmin.php',
        'lessc' => __DIR__ . '/..' . '/oyejorge/less.php/lessc.inc.php',
        'scss_formatter' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
        'scss_formatter_compressed' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
        'scss_formatter_crunched' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
        'scss_formatter_nested' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
        'scss_parser' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
        'scss_server' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
        'scssc' => __DIR__ . '/..' . '/leafo/scssphp/classmap.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1af4bf5e18a24ae696337a5c4440f667::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1af4bf5e18a24ae696337a5c4440f667::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit1af4bf5e18a24ae696337a5c4440f667::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit1af4bf5e18a24ae696337a5c4440f667::$classMap;

        }, null, ClassLoader::class);
    }
}