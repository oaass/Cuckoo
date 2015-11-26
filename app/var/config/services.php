<?php

use Phalcon\Mvc\Url;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Di\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionFiles;
use Phalcon\Security;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event as EventsManager;

/**
 * Initialize dependency injector
 */
$di = new FactoryDefault();

/**
 * Register url
 */
$di->set('url', function () use ($config) {
    $url = new Url();
    $url->setBaseUri($config->project->baseUrl);
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

$di->setShared('dispatcher', function () use ($di) {

    $eventsManager = $di->getShared('eventsManager');
    $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward([
                    'namespace' => 'Cuckoo\Modules\System\Controllers',
                    'module' => 'system',
                    'controller' => 'errors',
                    'action'     => 'error',
                    'params' => ['code' => '404']
                ]);
                return false;
        }
    });

    $dispatcher = new MvcDispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;

});

return $di;