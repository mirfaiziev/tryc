<?php
// I don't want to write file parser now, so hi yii way )
return [
    'dataDir' => __DIR__.'/../../data/',
    'mode' => 'dev',

    'defaultModule' => 'index',
    'defaultController' => 'index',

    'controller4xx' => 'My\Module\\index\\error4xxController',
    'action404' => 'action404',

];