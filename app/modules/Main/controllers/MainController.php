<?php

/**
 * @package App
 * @subpackage Modules\Main\Controllers
 */
namespace App\Modules\Main\Controllers;

/**
 * @uses Cuckoo\Phalcon\Mvc\Controller
 */
use Cuckoo\Phalcon\Mvc\Controller;

/**
 * Main module index controller
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package App
 * @subpackage Modules\Main\Controllers
 */
class MainController extends Controller
{
    public function indexAction()
    {
        echo __METHOD__;
        
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