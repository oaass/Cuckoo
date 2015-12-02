<?php

/**
 * @package App
 * @subpackage Modules\Main
 */
namespace App\Modules\Main;

/** 
 * @uses Cuckoo\Phalcon\Mvc\Module
 * @uses Cuckoo\Phalcon\Plugins\Security
 */
use Cuckoo\Phalcon\Mvc\Module as ModuleBase;
use Cuckoo\Phalcon\Plugins\Security;

/**
 * Module bootstrap object
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package App
 * @subpackage Modules\Main
 */
class Module extends ModuleBase
{

    /**
     * Object constructor
     *
     * Setting up path, namespaces, default namespace, etc for the module to be 
     * able to load properly
     */
    public function __construct()
    {
        parent::__construct();
        $this->path  = __DIR__;
        $this->namespaces = [
            'App\Modules\Main\Controllers' => $this->path . '/controllers',
            'App\Modules\Main\Models' => $this->path . '/models'
        ];
        $this->defaultNamespace = 'App\Modules\Main\Controllers';
    }

    /**
     * Register services
     *
     * This is required to register the module with the ACL
     *
     * @param \Phalcon\DI\FactoryDefault $di
     *
     * @access public
     * @return void
     */
    public function registerServices($di)
    {
        // Register default services
        parent::registerServices($di);

        $security = new Security($di);
        $security->addPublicResources('main', [
            'index', 'about'
        ]);
        $security->addPrivateResources('main', [
            'private'
        ], 'Users');
        $security->addPrivateResources('main', [
            'admin'
        ], 'Administrators');

        // Register the ACL dispatcher
        parent::registerAclDispatcher($di, $security);
    }

}