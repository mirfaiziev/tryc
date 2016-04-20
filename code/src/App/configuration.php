<?php
// I don't want to write file parser now, so hi yii way )
return [
    'dataDir' => __DIR__.'/../../data/',
    'mode' => 'dev',

    'defaultModule' => 'index',
    'defaultController' => 'index',

    'errorController' => 'My\\Module\\index\\Controller\\errorController',
    'action404' => 'action404',

];