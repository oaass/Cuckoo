<?php

$di->setShared('router', function () use ($modules) {

    $router = new \Phalcon\Mvc\Router();
    $router->removeExtraSlashes(true);

    // Import module routes
    foreach ($modules as $module) {
        include dirname($module['path']) . '/routes.php';
    }

    return $router;

});