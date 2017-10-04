<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

//return [
//    // ...
//];

return [
    'db' => [
       'driver' => 'Pdo',
         'dsn' => 'mysql:dbname=zend;host=127.0.0.1',      
         'driver_options' => array(
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')
          ],
    
     'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
                'pages'=>array(
                    array(
                        'label' => 'Moja metoda',
                        'route' => 'application',
                        'action' => 'waslmethod'
                    )
                )
            ],
                       
            array(
            'label' => 'Album',
            'route' => 'album',
            'pages' => array(
                array(
                    'label' => 'Add',
                    'route' => 'album',
                    'action' => 'add',
                    'pages' => array(
                        array(
                                'label' => 'S1',
                                'uri' =>'#',
                                'pages' => array(
                                        array(
                                        'label' => 'S3',
                                        'uri' =>'#'),
                                        array(
                                            'label' => 'S4',
                                            'uri' =>'#',
                                            'pages' => array(
                                                        array(
                                                                'label' => 'S1',
                                                                'uri' =>'http://www.wp.pl',
                                                                'target' =>'blank',
                                                                'pages' => array(
                                                                        array(
                                                                        'label' => 'S3',
                                                                        'uri' =>'#'),
                                                                        array(
                                                                            'label' => 'S4',
                                                                            'uri' =>'#'),

                                                                )
                                                        ),
                                                        array(
                                                                'label' => 'S2',
                                                                'uri' =>'#',
                                                                'pages' => array(
                                                                            array(
                                                                                    'label' => 'S1',
                                                                                    'uri' =>'#',
                                                                                    'pages' => array(
                                                                                            array(
                                                                                            'label' => 'S3',
                                                                                            'uri' =>'#'),
                                                                                            array(
                                                                                                'label' => 'S4',
                                                                                                'uri' =>'#'),

                                                                                    )
                                                                            ),
                                                                            array(
                                                                                    'label' => 'S2',
                                                                                    'uri' =>'#',
                                                                                    'pages' => array(
                                                                                                array(
                                                                                                        'label' => 'S1',
                                                                                                        'uri' =>'#',
                                                                                                        'pages' => array(
                                                                                                                array(
                                                                                                                'label' => 'S3',
                                                                                                                'uri' =>'#'),
                                                                                                                array(
                                                                                                                    'label' => 'S4',
                                                                                                                    'uri' =>'#'),

                                                                                                        )
                                                                                                ),
                                                                                                array(
                                                                                                        'label' => 'S2',
                                                                                                        'uri' =>'#',
                                                                                                        'pages' => array(
                                                                                                                    array(
                                                                                                                            'label' => 'S1',
                                                                                                                            'uri' =>'#',
                                                                                                                            'pages' => array(
                                                                                                                                    array(
                                                                                                                                    'label' => 'S3',
                                                                                                                                    'uri' =>'#'),
                                                                                                                                    array(
                                                                                                                                        'label' => 'S4',
                                                                                                                                        'uri' =>'#'),

                                                                                                                            )
                                                                                                                    ),
                                                                                                                    array(
                                                                                                                            'label' => 'S2',
                                                                                                                            'uri' =>'#'
                                                                                                                    )
                                                                                                                )
                                                                                                )
                                                                                            )
                                                                            )
                                                                        )
                                                        )
                                                    )
                                            
                                            ),
                                                                                            
                                             
                                            
                                )
                        ),
                        array(
                                'label' => 'S2',
                                'uri' =>'#'
                        )
                    )
                ),
                array(
                    'label' => 'Edit',
                    'route' => 'album',
                    'action' => 'edit',
                ),
                array(
                    'label' => 'Delete',
                    'route' => 'album',
                    'action' => 'delete',
                    'pages' => array(
                        array(
                                'label' => 'S1',
                                'uri' =>'#',
                                'pages' => array(
                                        array(
                                        'label' => 'S3',
                                        'uri' =>'#')
                                )
                        ),
                        array(
                                'label' => 'S2',
                                'uri' =>'#'
                        )
                    )
                ),
                ),                
            ),
             array(
            'label' => 'Pojazd',
            'route' => 'pojazd',
            'pages' => array(
                array(
                    'label' => 'Add',
                    'route' => 'pojazd',
                    'action' => 'add',
                ),
                array(
                    'label' => 'Edit',
                    'route' => 'album',
                    'action' => 'edit',
                ),
                array(
                    'label' => 'Delete',
                    'route' => 'album',
                    'action' => 'delete',
                ),
                ),                
            ),
          
            
            array(
              'label' => 'Test',
              'route'=>'test',              
            ), 
            array(
              'label' => 'Panel administracyjny',
              'route'=>'admin',              
            ), 
            
             array(
              'label' => 'Logowanie',
              'route'=>'admin',
              'action' => 'login'
            ), 
           
        ],
    ],
//        'service_manager' => [
//        'factories' => [
//            'navigation' => Zend\Navigation\Service\DefaultNavigationFactory::class,
//        ],
//    ],
    
//    'service_manager' => [
//        'factories' => [
//            'navigation' => Zend\Navigation\Service\DefaultNavigationFactory::class,
//        ],
//    ],
    

    
];