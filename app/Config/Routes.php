<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/student', 'Home::studentView');
$routes->get('/register', 'Home::registerUser');
$routes->get('/forgot', 'Home::forgotRegister');