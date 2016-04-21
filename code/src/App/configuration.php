<?php
// I don't want to write file parser now, so hi yii way )
return [
    'dataFile' => __DIR__.'/../../data/example.csv',
    'mode' => 'dev',

    'defaultModule' => 'index',
    'defaultController' => 'index',

    'errorController' => 'My\\Module\\index\\Controller\\errorController',
    'action404' => 'action404',
    'action500' => 'action500',

];