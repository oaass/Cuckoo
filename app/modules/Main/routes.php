<?php

$router->add('/', [
    'module' => 'main',
    'controller' => 'index',
    'action' => 'index'
]);

$router->add('/about', [
    'module' => 'main',
    'controller' => 'index',
    'action' => 'about'
]);

$router->add('/private', [
    'module' => 'main',
    'controller' => 'index',
    'action' => 'private'
]);

$router->add('/admin', [
    'module' => 'main', 
    'controller' => 'index',
    'action' => 'admin'
]);