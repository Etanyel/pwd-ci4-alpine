<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/login', 'AuthController::login');

$routes->post('/register-user', 'UserController::registerUser');

$routes->get('/logout', 'AuthController::logout');



// Error pages
$routes->get('/unauthorized', function () {
    return view('errors/html/unauthorized');
});
