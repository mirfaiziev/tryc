<?php

require_once __DIR__.'/../src/App/register_autoloaders.php';

$app = My\App\App::getInstance();
$app->initConfig(require_once __DIR__.'/../src/App/configuration.php');
$app->run();