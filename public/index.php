<?php


try {
    define('__ROOT__', realpath('..'));
    define('APP_PATH', __ROOT__ . '/app');
    define('PUB_PATH', __ROOT__ . '/public');

    $configPath = APP_PATH . '/var/config';

    // Load configuartion
    $config = include $configPath . '/config.php';

    // Load services
    $di = include $configPath . '/services.php';

    // Load modules
    $modules = include $configPath . '/modules.php';

    include $configPath . '/router.php';

    include $configPath . '/loader.php';

    $app = new \Phalcon\Mvc\Application($di);
    $app->registerModules($modules);

    echo $app->handle()->getContent();
} catch (\Exception $e) {
    echo get_class($e) . ': ' . $e->getMessage(), "<br>\n";
    echo " File=", $e->getFile(), "<br>\n";
    echo " Line=", $e->getLine(), "<br>\n";
    echo "<hr>\n";
    echo nl2br($e->getTraceAsString());
}