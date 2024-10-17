<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->group('admin',static function ($routes) {
    $routes->get('',[], static function ($routes) {
        $routes->view('examplePage','examplePage');
    });

    $routes->get('',[], static function ($routes) {
        $routes->view('exampleAuth','exampleAuth');
    });

});
