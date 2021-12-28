<?php

declare(strict_types=1);

namespace Application;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

$db = [
  'driver'      => 'oci8',
  'username'    => 'wwwu',
  'password'    => 'frsutf8',
  'connection_string' => 'NQ3',
  'charset'     => 'utf8',
  'persistent'  => 'true',
];
if (APPLICATION_ENV == 'development') {
  $db = [
  'driver'      => 'oci8',
  'username'    => 'wwwu_test',
  'password'    => 'frstestutf8',
  'connection_string' => 'NQ3',
  'charset'     => 'utf8',
  'persistent'  => 'true',
  ];
}

return [
  'router' => [
    'routes' => [
      'home' => [
        'type'  => Literal::class,
        'options' => [
          'route'  => '/',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action'   => 'index',
          ],
        ],
      ],
      'application' => [
        'type'  => Segment::class,
        'options' => [
          'route'  => '/application[/:action]',
          'defaults' => [
            'controller' => Controller\IndexController::class,
            'action'   => 'index',
          ],
        ],
      ],
    ],
  ],
  'db' => $db,
  'controllers' => [
    'factories' => [
      // Controller\IndexController::class => InvokableFactory::class,
      Controller\IndexController::class => function($container) {
        $db = $container->get(AdapterInterface::class);
        return new Controller\IndexController($db);
      },
    ],
  ],
  'view_manager' => [
    'display_not_found_reason' => true,
    'display_exceptions'     => true,
    'doctype'          => 'HTML5',
    'not_found_template'     => 'error/404',
    'exception_template'     => 'error/index',
    'template_map' => [
      'layout/layout'       => __DIR__ . '/../view/layout/layout.phtml',
      'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
      'error/404'         => __DIR__ . '/../view/error/404.phtml',
      'error/index'       => __DIR__ . '/../view/error/index.phtml',
    ],
    'template_path_stack' => [
      __DIR__ . '/../view',
    ],
  ],
];
