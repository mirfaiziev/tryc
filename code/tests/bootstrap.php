<?php

// add tests directory for each autoload records in configuration
require_once __DIR__ . '/../app/autoload.php';

$configuration = require_once __DIR__ . '/../app/configuration.php';

$autoLoader = new \App\Autoload();

$autoloads = $configuration['autoload'];
foreach ($autoloads as $name => $item) {
    $autoLoader->addClassMap($item['prefix'], $item['baseDir']);

    $testDir = $item['baseDir'] . '/../tests';
    $autoLoader->addClassMap($item['prefix'], $testDir);
}

$autoLoader->register();