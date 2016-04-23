<?php

require_once __DIR__ . '/../app/app.php';

$app = App\App::getInstance();
$app->init(require_once __DIR__ . '/../app/configuration.php');
$app->run();
/*require_once __DIR__ . '/../src/App/autoload.php';

$app = My\App\App::getInstance();
$app->init(require_once __DIR__.'/../src/App/configuration.php');
$app->run();*/