<?php

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces([
    'Cuckoo\Modules\Core' => APP_PATH . '/modules/Core',
    'Cuckoo\Modules\Custom' => APP_PATH . '/modules/Custom',
    'Cuckoo\Library' => APP_PATH . '/library/Cuckoo',
    'Cuckoo\Widgets' => APP_PATH . '/widgets',
]);

$loader->register();