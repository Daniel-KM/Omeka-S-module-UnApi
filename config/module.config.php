<?php
namespace UnApi;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'controllers' => [
        'invokables' => [
            Controller\IndexController::class => Controller\IndexController::class,
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
                        'controller' => 'IndexController',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
];
