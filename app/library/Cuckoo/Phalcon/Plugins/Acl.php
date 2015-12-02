<?php

/**
 * @package Cuckoo
 * @subpackage Phalcon\Plugins
 */
namespace Cuckoo\Phalcon\Plugins;

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
 * @subpackage Phalcon\Plugins
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
    public $privateResources = [];

    /**
     * @var array $publicResources
     */
    public $publicResources = [];

    /**
     * @var array $roles
     */
    public $roles;

    /**
     * @var array $roleNames
     */
    public $roleNames;

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
    public function __construct(AdapterInterface $adapter, array $public, array $private, array $roles)
    {
        $this->adapter = $adapter;
        $this->privateResources = $private;
        $this->publicResources = $public;

        // Build roles array
        array_walk($roles, function ($name, $key) {
            $this->roles[] = $name;
            $name = (is_array($name)) ? $name[0] : $name;          
            $this->rolesInstances[$name] = new Role(ucfirst($name));
        });


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
     * @return \Cuckoo\Phalcon\Plugins\Acl
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
        array_walk($this->roles, function ($role, $key) {
            if (is_array($role)) {
                $roles = [
                    $this->rolesInstances[$role[0]], // Main role
                    $this->rolesInstances[$role[1]] // Inherit from this role
                ];
            } else {
                $roles = [
                    $this->rolesInstances[$role]
                ];
            }
            call_user_func_array([$this->adapter, 'addRole'], $roles);
        });
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
        switch ($type) {
            case self::RESOURCE_PRIVATE:
                array_map(function($resources) {
                    array_walk($resources, function ($actions, $resource) {
                        $this->adapter->addResource(new Resource($resource), $actions);
                    });                    
                }, $resources);
                break;
            case self::RESOURCE_PUBLIC:
            default:
                array_walk($resources, function ($actions, $resource) {
                    $this->adapter->addResource(new Resource($resource), $actions);
                });
                break;
        }
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
        array_map(function ($role) {
            $roleName = $role->getName();
            if (isset($this->privateResources[$roleName])) {    
                array_walk($this->privateResources[$roleName], function ($actions, $resource) use ($role) {
                    $this->grantAccessToResource($role, $resource, $actions);
                });
            }
        }, $this->rolesInstances);
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
        }, $this->rolesInstances);
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