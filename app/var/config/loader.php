<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces([
    'Cuckoo' => APP_PATH . '/library/Cuckoo',
    'App\Modules' => APP_PATH . '/modules',
    'App\Widgets' => APP_PATH . '/widgets',
    'App\Shared' => APP_PATH . '/shared'
]);

$loader->register();