<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;



class Module implements ConfigProviderInterface
{
    
    
    public function getConfig()
    {       
        
        return include __DIR__ . '/../config/module.config.php';
        
        
    }
    
     public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AlbumTable::class => function($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
                 Model\KolorTable::class => function($container) {
                    $tableGateway = $container->get(Model\KolorTableGateway::class);
                    return new Model\KolorTable($tableGateway);
                },
                Model\KolorTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Kolor());
                    return new TableGateway('kolory', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
     public function getControllerConfig()
    {                          
        return [
            'factories' => [
                Controller\AlbumController::class => function($container) {
                    return new Controller\AlbumController(
                        $container->get(Model\AlbumTable::class),
                            $container->get(Model\KolorTable::class)
                    );
                },
                 Controller\PojazdController::class => function($container) {
                    return new Controller\PojazdController(
                        $container->get(Model\AlbumTable::class),
                            $container->get(Model\KolorTable::class)
                    );
                },
            ],
        ];
    }
    
   
}