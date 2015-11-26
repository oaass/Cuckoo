<?php

$router->add('/', [
    'module' => 'main',
    'controller' => 'main',
    'action' => 'index'
]);

$router->add('/about', [
    'module' => 'main',
    'controller' => 'main',
    'action' => 'about'
]);

$router->add('/private', [
    'module' => 'main',
    'controller' => 'main',
    'action' => 'private'
]);

$router->add('/admin', [
    'module' => 'main', 
    'controller' => 'main',
    'action' => 'admin'
]);