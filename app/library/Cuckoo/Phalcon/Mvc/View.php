<?php

/**
 * @package Cuckoo
 * @subpackage Library\Phalcon\Mvc
 */
namespace Cuckoo\Library\Phalcon\Mvc;

/**
 * @uses Phalcon\Mvc\View
 */
use Phalcon\Mvc\View as PhalconView;

/**
 * Extending Phalcon's view object
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Library\Phalcon\Mvc
 */
class View extends PhalconView
{
    /**
     * Check if the given view file exists
     *
     * @param string $view
     *
     * @access public
     * @return boolean
     */
    public function exists($view)
    {
        $path = $this->getViewsDir();
        $viewPath = $path . $view . '.phtml';
        return (file_exists($viewPath));
    }
}