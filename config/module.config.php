<?php
return [
    'controllers' => [
        'invokables' => [
            'UnApi\Controller\Index' => 'UnApi\Controller\IndexController',
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH . '/module/UnApi/view',
        ],
    ],
    'router' => [
        'routes' => [
            'unapi' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/unapi',
                    'defaults' => [
                        '__NAMESPACE__' => 'UnApi\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
];
