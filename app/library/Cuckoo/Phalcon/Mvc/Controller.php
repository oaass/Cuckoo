<?php

/**
 * @package Cuckoo
 * @subpackage Library\Phalcon\Mvc
 */
namespace Cuckoo\Library\Phalcon\Mvc;

/**
 * @uses Phalcon\Mvc\Controller
 */
use Phalcon\Mvc\Controller as PhalconController;

/**
 * Extends Phalcon's MVC controller
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Library\Phalcon\Mvc
 */
class Controller extends PhalconController
{
    public function initialize()
    {}

    public function showErrorPage($code)
    {
        $this->view->setViewsDir(APP_PATH . '/modules/System/views');

        $this->view->setVar('t', $translation);

        $viewFile = "errors/{$code}";

        if ($this->view->exists($viewFile)) {
            $this->view->pick([$viewFile]);
        } else {
            $this->view->pick(['errors/404']);
        }
    }
}