<?php

/**
 * @package App
 * @subpackage Modules\System\Controllers
 */
namespace App\Modules\System\Controllers;

/**
 * @uses Cuckoo\Phalcon\Mvc\Controller
 */
use Cuckoo\Phalcon\Mvc\Controller;

/**
 * System module's error controller
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package App
 * @subpackage Modules\System\Controllers
 */
class ErrorsController extends Controller
{
    /**
     * Display 404 page
     *
     * @access public
     * @return void
     */
    public function errorAction()
    {
        $code = $this->dispatcher->getParam('code');

        $viewFile = "errors/{$code}";

        if ($this->view->exists($viewFile)) {
            return $this->view->pick($viewFile);
        } else {
            return $this->view->pick('errors/404');
        }
    }
}