<?php

$router->add('/error/:int', [
    'module' => 'system',
    'controller' => 'error',
    'action' => 'error',
    'code' => 1
]);