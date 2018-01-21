<?php
namespace UnApi;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            Form\ConfigForm::class => Form\ConfigForm::class,
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
    'unapi' => [
        'config' => [
            'unapi_public_server' => true,
        ],
    ],
];
