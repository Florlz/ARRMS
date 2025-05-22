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
$routes->post('student/document-types', 'StudentController::getDocumentTypes');
$routes->post('student/submit-request', 'StudentController::submitRequest');
$routes->post('student/request-status', 'StudentController::getRequestStatus');
$routes->post('student/request-counts', 'StudentController::getRequestCounts');
$routes->post('student/cancel-request', 'StudentController::cancelRequest');
$routes->get('student/generate-qr-code/(:num)', 'StudentController::generateQRCode/$1'); // Changed to GET and added placeholder
$routes->get('student/download-receipt/(:num)', 'StudentController::downloadReceipt/$1');
$routes->post('student/ready-for-pickup-count', 'StudentController::getReadyForPickupCount'); // Added route for ready for pickup count
$routes->post('logout', 'LoginController::logout'); // Route for logout, changed to POST

// Admin Routes
$routes->get('admin', 'AdminController::index');
$routes->get('admin/dashboard', 'AdminController::dashboard');
$routes->post('admin/users', 'AdminController::getUsers');
$routes->get('admin/user/(:num)', 'AdminController::getUserDetails/$1');
$routes->post('admin/requests', 'AdminController::getRequests');
$routes->post('admin/request-counts', 'AdminController::getRequestCounts');
$routes->post('admin/update-request-status', 'AdminController::updateRequestStatus');
$routes->get('admin/request-history/(:num)', 'AdminController::getRequestHistory/$1');
$routes->get('admin/document-types', 'AdminController::getDocumentTypes');
$routes->get('admin/colleges', 'AdminController::getColleges');
$routes->get('admin/dashboard-summary', 'AdminController::getDashboardSummary');

// Cashier Gateway Routes
$routes->get('admin/cashier', 'AdminController::cashierGateway');
$routes->get('admin/get-request-details/(:num)', 'AdminController::getRequestDetailsById/$1');
$routes->post('admin/process-payment', 'AdminController::processPayment');
