<?php

require_once __DIR__ . '/../src/App/autoload.php';

$app = My\App\App::getInstance();
$app->init(require_once __DIR__.'/../src/App/configuration.php');
$app->run();