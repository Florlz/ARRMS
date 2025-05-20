<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/student', 'Home::studentView');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/store', 'RegisterController::store');
$routes->get('/forgot', 'Home::forgotRegister');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->post('student/update', 'StudentController::update');
$routes->get('student', 'StudentController::index');