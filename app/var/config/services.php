<?php

use Phalcon\Mvc\Url;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Di\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionFiles;
use Phalcon\Security;

/**
 * Initialize dependency injector
 */
$di = new FactoryDefault();

/**
 * Register url
 */
$di->set('url', function () {
    $url = new Url();
    $url->setBaseUri('/lab/phalcon/hmvc/');
    return $url;
});

/**
 * Register configuration
 */
$di->setShared('config', function () use ($config) {
    return $config;
});

/**
 * Register session handler
 */
$di->setShared('session', function () {
    $session = new SessionFiles();
    $session->start();
    return $session;
});

/**
 * Register session flash messages
 */
$di->set('flash', function () {
    $flash = new FlashSession();
    return $flash;
});

$di->setShared('security', function () use ($config) {
    $security = new Security();
    $security->setWorkFactor($config->security->workFactor);
    $security->setDefaultHash($config->security->hash);
    return $security;
});

$di->setShared('filter', function () {
    $filter = new \Phalcon\Filter;
    return $filter;
});

return $di;