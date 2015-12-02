<?php

/**
 * @package App
 * @subpackage Modules\System
 */
namespace App\Modules\System;

/**
 * @uses Cuckoo\Phalcon\Mvc\Module
 */
use Cuckoo\Phalcon\Mvc\Module as ModuleBase;

/**
 * Module bootstrap object
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package App
 * @subpackage Modules\System
 */
class Module extends ModuleBase
{

    /**
     * Object constructor
     *
     * Bootstrapping everything that's required to successfully load the module
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->path = __DIR__;
        $this->namespaces = [
            'App\Modules\System\Controllers' => $this->path . '/controllers',
            'App\Modules\System\Models' => $this->path . '/models'
        ];
        $this->defaultNamespace = 'App\Modules\System\Controllers';
    }

}