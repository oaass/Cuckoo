<?php

/**
 * @package Cuckoo
 * @subpackage Library\Phalcon\Plugins
 */
namespace Cuckoo\Library\Phalcon\Plugins;

/**
 * @uses Phalcon\Acl\AdapterInterface
 * @uses Phalcon\Acl\Adapter\Memory
 * @uses Phalcon\Acl
 * @uses Cuckoo\Library\Phalcon\Plugins\Acl
 * @uses Phalcon\Mvc\User\Plugin
 * @uses Phalcon\Mvc\Dispatcher
 * @uses Phalcon\Events\Event
 */
use Phalcon\Acl\AdapterInterface;
use Phalcon\Acl\Adapter\Memory as AclAdapter;
use Phalcon\Acl as PhalconAcl;
use Cuckoo\Library\Phalcon\Plugins\Acl as CuckooAcl;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;

/**
 * Security plugin to handle things like ACL
 *
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Library\Phalcon\Plugins 
 */
class Security extends Plugin
{
    /**
     * @var array $privateResources
     */
    public $privateResources = [];

    /**
     * @var array $publicResources
     */
    public $publicResources = [];

    /**
     * Add public resources
     * 
     * @param string $resource
     * @param array $actions
     *
     * @access public
     * @return void
     */
    public function addPublicResources($resource, array $actions)
    {
        $this->publicResources[$resource] = $actions;
    }

    /**
     * Add private resources
     *
     * @param string $resource
     * @param array $actions
     * @param array $roles
     *
     * @access public
     * @return void
     */
    public function addPrivateResources($resource, array $actions, $roles)
    {
        if (!is_array($roles)) {
            $roles = array($roles);
        }

        array_walk($roles, function($role, $key) use ($resource, $actions) {
            $this->privateResources[$role][$resource] = $actions;
        });
    }

    /**
     * Set up event listener
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     *
     * @access public
     * @return mixed
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $role = $this->config->security->acl->defaultRole;

        if ($this->session->has('auth')) {
            $role = $this->session->get('role');
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        $allowed = $acl->isAllowed($role, $controller, $action);

        if ($allowed != PhalconAcl::ALLOW) {
            $this->flash->error('You do not have access to this module');
            $this->response->setStatusCode(401, 'Not authorized');
            $this->response->redirect('error/401');
            return false;
        }
    }

    /**
     * Get ACL instance
     *
     * @access public
     * @return \Cuckoo\Library\Phalcon\Plugins\Acl
     */
    public function getAcl()
    {
        $this->persistent->destroy();
        if (!isset($this->persistent->acl)) {
            $adapter = new AclAdapter;
            $adapter->setDefaultAction(PhalconAcl::DENY);

            $roles = $this->config->security->acl->roles->toArray();

            $acl = new CuckooAcl($adapter,
                                $this->publicResources,
                                $this->privateResources,
                                $roles);

            $this->persistent->acl = $acl->initialize()->getAcl();
        }

        return $this->persistent->acl;
    }
}