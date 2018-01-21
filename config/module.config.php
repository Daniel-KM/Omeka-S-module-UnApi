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
            'Unapi\Controller\Index' => Controller\IndexController::class,
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
