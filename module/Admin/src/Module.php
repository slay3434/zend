<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface {

    public function getConfig() {

        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig() {
        return [
            'factories' => [
                Model\AclPermissionsTable::class => function($container) {
                    $tableGateway = $container->get(Model\AclPermissionsTableGateway::class);
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Model\AclPermissionsTable($tableGateway, $dbAdapter);
                },
                Model\AclPermissionsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\AclPermissions());
                    return new TableGateway('aclpermissions', $dbAdapter, null, $resultSetPrototype);
                },
                Model\AclRolesTable::class => function($container) {
                    $tableGateway = $container->get(Model\AclRolesTableGateway::class);
                    $dbAdapter = $container->get(AdapterInterface::class);
                    return new Model\AclRolesTable($tableGateway, $dbAdapter);
                },
                Model\AclRolesTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\AclRoles());
                    return new TableGateway('aclroles', $dbAdapter, null, $resultSetPrototype);
                },
                Model\AclRolesPermissionsTable::class => function($container) {
                    $tableGateway = $container->get(Model\AclRolesPermissionsTableGateway::class);
                    return new Model\AclRolesPermissionsTable($tableGateway);
                },
                Model\AclRolesPermissionsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\AclRolesPermissions());
                    return new TableGateway('aclrolespermissions', $dbAdapter, null, $resultSetPrototype);
                },
                Model\AclUserTable::class => function($container) {
                    $tableGateway = $container->get(Model\AclUserTableGateway::class);
                    return new Model\AclUserTable($tableGateway);
                },
                Model\AclUserTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\AclUser());
                    return new TableGateway('acluser', $dbAdapter, null, $resultSetPrototype);
                },
                Model\AclUserRolesTable::class => function($container) {
                    $tableGateway = $container->get(Model\AclUserRolesGateway::class);
                    return new Model\AclUserRolesTable($tableGateway);
                },
                Model\AclUserRolesGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\AclUserRoles());
                    return new TableGateway('acluserroles', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                Controller\AdminController::class => function($container) {
                    return new Controller\AdminController(
                            $container->get(Model\AclRolesTable::class), 
                            $container->get(Model\AclRolesPermissionsTable::class), 
                            $container->get(Model\AclUserTable::class), 
                            $container->get(Model\AclUserRolesTable::class), 
                            $container->get(Model\AclPermissionsTable::class)
                    );
                },
            ],
        ];
    }

}
