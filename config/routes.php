<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Dwdm/Users',
    ['path' => '/users'],
    function (RouteBuilder $routes) {
        $routes->connect('/user-contacts/confirm/:id/:token',
            ['controller' => 'UserContacts', 'action' => 'confirm', '_method' => 'GET'], ['pass' => ['id', 'token']]);
        $routes->fallbacks(DashedRoute::class);
    }
);
