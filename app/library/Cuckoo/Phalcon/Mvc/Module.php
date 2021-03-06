<?php

/**
 * @package Cuckoo
 * @subpackage Phalcon\Mvc
 */
namespace Cuckoo\Phalcon\Mvc;

/**
 * @uses Phalcon\DI\FactoryDefault
 * @uses Phalcon\DI
 * @uses Phalcon\Loader
 * @uses Phalcon\Mvc\Dispatcher
 * @uses Cuckoo\Phalcon\Mvc\View
 * @uses Cuckoo\Phalcon\Plugins\Security
 */
use Phalcon\DI\FactoryDefault;
use Phalcon\DI;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Cuckoo\Phalcon\Mvc\View;
use Cuckoo\Phalcon\Plugins\Security;

/**
 * Module base
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Phalcon\Mvc
 */
class Module
{
    /**
     * @var $path
     */
    protected $path;

    /**
     * @var $namespaces
     */
    protected $namespaces;

    /**
     * @var $defaultNamespaces
     */
    protected $defaultNamespace;

    /**
     * @var $viewsPath
     */
    protected $viewsPath = '/views/';

    /**
     * @var $template
     */
    protected $template;

    /**
     * @var $layoutsPath
     */
    protected $layoutsPath;

    /**
     * Object constructor
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->namespaces = [];
        $this->template = '';
    }

    /**
     * Register auto loaders
     *
     * @access public
     * @return void
     */
    public function registerAutoloaders()
    {
        $loader = new Loader();
        $loader->registerNamespaces($this->namespaces);
        $loader->register();
    }

    /**
     * Register services
     *
     * @param \Phalcon\DI\FactoryDefault $di
     *
     * @access public
     * @return void
     */
    public function registerServices(\Phalcon\DI\FactoryDefault $di)
    {
        $this->registerViewService($di);
    }

    /**
     * Register view service
     *
     * @param \Phalcon\DI\FactoryDefault $di
     *
     * @access public
     * @return \Cuckoo\Phalcon\Mvc\View
     */
    public function registerViewService(\Phalcon\DI\FactoryDefault $di)
    {
        $di->setShared('view', function () use ($di) {
            $layout = $di->get('config')->project->layout;
            $this->layoutsPath = sprintf('../../../../%s/layouts/%s/', 'public', $layout);

            $view = new View();
            $view->setViewsDir($this->path . $this->viewsPath);
            $view->setLayoutsDir($this->layoutsPath);
            $view->setLayout('main');

            $view->registerEngines([
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
            ]);

            return $view;
        });
    }

    /**
     * Register ACL dispatcher
     *
     * @param \Phalcon\DI\FactoryDefault $di
     *
     * @access public
     * @return \Phalcon\Mvc\Dispatcher
     */
    public function registerAclDispatcher($di, Security $security)
    {
        $di->set('dispatcher', function () use ($di, $security) {
            $dispatcher = new Dispatcher;
            $dispatcher->setDefaultNamespace($this->defaultNamespace);

            $eventsManager = $di->getShared('eventsManager');
            $eventsManager->attach('dispatch', $security);

            $dispatcher->setEventsManager($eventsManager);
            
            return $dispatcher;
        });
    }

}