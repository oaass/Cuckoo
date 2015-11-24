<?php

/**
 * @package Cuckoo
 * @subpackage Modules\System
 */
namespace Cuckoo\Modules\System;

/**
 * @uses Cuckoo\Library\Phalcon\Mvc\Module
 */
use Cuckoo\Library\Phalcon\Mvc\Module as ModuleBase;

/**
 * Module bootstrap object
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
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
            'Cuckoo\Modules\System\Controllers' => $this->path . '/controllers',
            'Cuckoo\Modules\System\Models' => $this->path . '/models'
        ];
        $this->defaultNamespace = 'Cuckoo\Modules\System\Controllers';
    }

}