<?php
// I don't want to write file parser now, so hi yii way )
return [

        // as far I cannot use composer register autoload manually
    'autoload' => [
        'app' => [
            'prefix' => 'App\\',
            'baseDir' => __DIR__,
        ],

        'src' => [
            'prefix' => 'My\\',
            'baseDir' => __DIR__ . '/../src',
        ],
        'di' => [
            'prefix' => 'My\\Di\\',
            'baseDir' => __DIR__ . '/../vendor/my/di/src',
        ],

        'config' => [
            'prefix' => 'My\\Config\\',
            'baseDir' => __DIR__ . '/../vendor/my/config/src',
        ],

        'http-framework' => [
            'prefix' => 'My\\HttpFramework\\',
            'baseDir' => __DIR__ . '/../vendor/my/http-framework/src',
        ],

        'csv-data-handler' => [
            'prefix' => 'My\\CsvDataHandler\\',
            'baseDir' => __DIR__ . '/../vendor/my/csv-data-handler/src',
        ],
    ],

    'dataFile' => __DIR__ . '/../data/example.csv',

    'defaultModule' => 'index',
    'defaultController' => 'index',

    'errorModule' => '\\My\\Module\\index',
    'errorController' => '\\My\\Module\\index\\Controller\\errorController',
    'action404' => 'action404',
    'action400' => 'action400',
    'action500' => 'action500',

];