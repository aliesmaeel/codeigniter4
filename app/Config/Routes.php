<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/students', 'StudentController::index');
$routes->get('/students/create', 'StudentController::create');
$routes->post('/students/create', 'StudentController::store');
$routes->get('/student/edit/(:num)', 'StudentController::edit/$1');
$routes->put('/student/update/(:num)', 'StudentController::update/$1');
$routes->get('/student/delete/(:num)', 'StudentController::delete/$1');
