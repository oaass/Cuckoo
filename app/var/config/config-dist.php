<?php

return new \Phalcon\Config([
    'project' => [
        'name' => 'Project Name',
        'version' => '1.0',
        'isBeta' => true,
        'layout' => 'default'
    ],
    'database' => [
        'adapter' => 'mysql',
        'hostname' => 'localhost',
        'port' => 3306,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ],
    'security' => [
        'workFactor' => 10,
        'hash' => \Phalcon\Security::CRYPT_BLOWFISH_X
    ]
]);