<?php

/**
 * @package Cuckoo
 * @subpackage Modules\Main
 */
namespace Cuckoo\Modules\Main;

/** 
 * @uses Cuckoo\Library\Phalcon\Mvc\Module
 * @uses Cuckoo\Library\Phalcon\Plugins\Security
 */
use Cuckoo\Library\Phalcon\Mvc\Module as ModuleBase;
use Cuckoo\Library\Phalcon\Plugins\Security;

/**
 * Module bootstrap object
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
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
            'Cuckoo\Modules\Main\Controllers' => $this->path . '/controllers',
            'Cuckoo\Modules\Main\Models' => $this->path . '/models'
        ];
        $this->defaultNamespace = 'Cuckoo\Modules\Main\Controllers';
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
        $security->addPublicResources('index', [
            'index', 'about'
        ]);
        $security->addPrivateResources('index', [
            'private'
        ], 'Users');
        $security->addPrivateResources('index', [
            'admin'
        ], 'Administrators');

        // Register the ACL dispatcher
        parent::registerAclDispatcher($di, $security);
    }

}