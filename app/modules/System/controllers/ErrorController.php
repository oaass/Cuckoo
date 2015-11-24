<?php

/**
 * @package Cuckoo
 * @subpackage Modules\System\Controllers
 */
namespace Cuckoo\Modules\System\Controllers;

/**
 * @uses Cuckoo\Library\Phalcon\Mvc\Controller
 */
use Cuckoo\Library\Phalcon\Mvc\Controller;

/**
 * System module's error controller
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Modules\System\Controllers
 */
class ErrorController extends Controller
{
    /**
     * Display error pages
     *
     * @param integer $code
     *
     * @access public
     * @return void
     */
    public function errorAction($code)
    {
        $code = $this->filter->sanitize($code, 'absint');
        
        $viewFile = "error/{$code}";

        if ($this->view->exists($viewFile)) {
            $this->view->pick("error/{$code}");
        } else {
            $this->response->redirect('error/404');
        }
    }
}