<?php

/**
 * @package Cuckoo
 * @subpackage Library\Phalcon\Plugins
 */
namespace Cuckoo\Library\Phalcon\Plugins;

/**
 * @uses Phalcon\Acl\Role
 * @uses Phalcon\Acl\Resource
 * @uses Phalcon\Acl\AdapterInterface
 */
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Acl\AdapterInterface;

/** 
 * ACL - Access Control List
 * 
 * @author Ole Aass <ole@oleaass.com>
 * @package Cuckoo
 * @subpackage Library\Phalcon\Plugins
 */
class Acl
{
    const RESOURCE_PUBLIC = 'public';
    const RESOURCE_PRIVATE = 'private';

    /**
     * @var \Phalcon\Acl\AdapterInterface $adapter
     */
    public $adapter;

    /**
     * @var array $privateResources
     */
    public $privateResources;

    /**
     * @var array $publicResources
     */
    public $publicResources;

    /**
     * @var array $roles
     */
    public $roles;

    /**
     * Object constructor
     *
     * @param \Phalcon\Acl\AdapterInterface $adapter
     * @param array $public
     * @param array $private
     *
     * @access public
     * @return void
     */
    public function __construct(AdapterInterface $adapter, $public, $private)
    {
        $this->adapter = $adapter;
        $this->privateResources = $private;
        $this->publicResources = $public;

        $this->roles = [
            'users' => new Role('Users'),
            'guests' => new Role('Guests')
        ];
    }

    /**
     * Get ACL instance
     * 
     * @access public
     * @return \Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {
        return $this->adapter;
    }

    /**
     * Initialize object
     *
     * @access public
     * @return \Cuckoo\Library\Phalcon\Plugins\Acl
     */
    public function initialize()
    {
        $this->registerRoles();
        $this->registerPrivateResources($this->privateResources);
        $this->registerPublicResources($this->publicResources);
        $this->grantAccessToPublicResources();
        $this->grantAccessToPrivateResources();
        return $this;
    }

    /**
     * Register ACL roles
     *
     * @access public
     * @return void
     */
    public function registerRoles()
    {
        array_map([$this->adapter, 'addRole'], $this->roles);
    }

    /**
     * Register resources
     *
     * @param array $resources
     * @param string $type
     *
     * @access public
     * @return void
     */
    public function registerResources(array $resources, $type = self::RESOURCE_PUBLIC)
    {
        array_walk($resources, function ($actions, $resource) {
            $this->adapter->addResource(new Resource($resource), $actions);
        });
    }

    /**
     * Register private resources
     *
     * @param array $resources
     *
     * @access public
     * @return void
     */
    public function registerPrivateResources(array $resources)
    {
        $this->registerResources($resources, self::RESOURCE_PRIVATE);
    }

    /**
     * Register public resources
     *
     * @param array $resources
     *
     * @access public
     * @return void
     */
    public function registerPublicResources(array $resources)
    {
        $this->registerResources($resources, self::RESOURCE_PUBLIC);
    }

    /**
     * Give roles access to private resources
     *
     * @access public
     * @return void
     */
    public function grantAccessToPrivateResources()
    {
        array_walk($this->privateResources, function ($actions, $resource) {
            $this->grantAccessToResource($this->roles['users'], $resource, $actions);
        });
    }

    /**
     * Give everyone access to public resources
     *
     * @access public
     * @return void
     */
    public function grantAccessToPublicResources()
    {
        array_map(function (Role $role) {
            array_walk($this->publicResources, function ($actions, $resource) use ($role) {
                $this->grantAccessToResource($role, $resource, $actions);
            });
        }, $this->roles);
    }

    /**
     * Give a role access to a resource
     *
     * @param \Phalcon\Acl\Role $role
     * @param string $resource
     * @param array $actions
     *
     * @access public
     * @return void
     */
    public function grantAccessToResource(Role $role, $resource, array $actions)
    {
        $this->adapter->allow($role->getName(), $resource, $actions);
    }
}