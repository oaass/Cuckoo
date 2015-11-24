<?php

/**
 * @package Cuckoo
 * @subpackage Modules\Main\Controllers
 */
namespace Cuckoo\Modules\Main\Controllers;

/**
 * @uses Cuckoo\Library\Phalcon\Mvc\Controller
 */
use Cuckoo\Library\Phalcon\Mvc\Controller;

/**
 * Main module index controller
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Modules\Main\Controllers
 */
class IndexController extends Controller
{
    public function indexAction()
    {
        echo __METHOD__;
        $this->view->disable();
    }

    public function aboutAction()
    {
        echo __METHOD__;
    }

    public function privateAction()
    {
        echo __METHOD__;
    }

    public function adminAction()
    {
        echo __METHOD__;
    }
}