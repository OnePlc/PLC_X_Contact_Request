<?php
/**
 * module.config.php - Request Config
 *
 * Main Config File for Contact Request Plugin
 *
 * @category Config
 * @package Contact\Request
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Request;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Request Module - Routes
    'router' => [
        'routes' => [
            'contact-request' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contact/request[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\RequestController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'contact-request-setup' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contact/request/setup',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
            'contact-request-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contact/request/api[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ], # Routes

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'contact-request' => __DIR__ . '/../view',
        ],
    ],
];
