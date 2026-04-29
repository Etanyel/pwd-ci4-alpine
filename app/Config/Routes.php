<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Guest
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('/', 'Home::index');

    $routes->post('/login', 'AuthController::login');
});


// With Auth
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Admin 
    $routes->group('', ['filter' => 'role:admin'], function ($routes) {
        $routes->get('/admin/pdao', 'AdminPageController::index');
        $routes->get('/admin/manage-users', 'AdminPageController::manageUserPage');


        $routes->get('/admin/add-record', 'AddRecordPageController::index');
        $routes->post('/admin/add-record', 'AddRecordPageController::addRecord');
        $routes->get('/admin/fetch-cause/(:num)', 'AddRecordPageController::fetchCause/$1'); //fetch cause based on id
        $routes->get('/admin/fetch-disability', 'AddRecordPageController::fetchDisability'); //fetch Disability
        $routes->get('/fetch-regions', 'LocationController::fetchRegions');
        $routes->get('/fetch-province/(:any)', 'LocationController::fetchProvinces/$1');
        $routes->get('/fetch-cities/(:any)', 'LocationController::fetchCities/$1');
        $routes->get('/fetch-barangays/(:any)', 'LocationController::fetchBarangays/$1');
        $routes->get('/fetch-occupation', 'AddRecordPageController::fetchOccupation'); // Occupations

        $routes->get('/admin/manage-records', 'ManageRecordPageController::index');
        $routes->get('/admin/fetch-records', 'ManageRecordPageController::fetchRecords'); //Fetch all records
        $routes->get('/admin/fetch-records/(:num)', 'ManageRecordPageController::fetchRecord/$1'); //Fetch record based on id
        $routes->get('/admin/manage-record/(:num)', 'ManageRecordPageController::manageRecord/$1'); //Fetch record based on id
        $routes->post('/admin/update-record/(:num)', 'ManageRecordPageController::updateRecord/$1'); //update record based on id
        $routes->post('/admin/upload-person-photo', 'ManageRecordPageController::uploadPhoto'); //update record based on id

        $routes->get('/admin/print-id/(:num)', 'ManageRecordPageController::printId/$1'); //print id based on id
        $routes->get('/admin/print-id-back/(:num)', 'ManageRecordPageController::printBack/$1'); //print back id based on id
        $routes->get('/admin/print/log/(:any)', 'ManageRecordPageController::printLog/$1'); //Make log when printing IDs


        // Manage User Page Index
        $routes->post('/register-user', 'UserController::registerUser');
        // Manage User Page
        $routes->get('/admin/fetch-users', 'UserPageController::fetchUsers'); //Fetch all users
        $routes->get('/admin/fetch-users/(:num)', 'ShowUserPageController::fetchUser/$1'); //Fetch User
        $routes->get('/admin/fetch-user-profile/(:num)', 'ShowUserPageController::fetchUserProfile/$1'); //Fetch user for ajax
        $routes->post('/admin/user-change-pass', 'ShowUserPageController::changePass'); //Change User Password
        $routes->post('/admin/upload-user-photo', 'ShowUserPageController::uploadPhoto'); //update user profile photo
        $routes->post('/admin/user-update-info/', 'ShowUserPageController::updateInfo'); //update user personal info
    });

    // User
    $routes->group('', ['filter' => 'role:user'], function ($routes) {
        $routes->get('/pdao', 'UserPageController::index');

        $routes->post('/pdao', 'UserController::registerUser');
    });

    $routes->get('/logout', 'AuthController::logout');
});



// Error pages
$routes->get('/unauthorized', function () {
    return view('errors/html/unauthorized');
});

$routes->get('/forbidden', function () {
    return view('errors/html/forbidden');
});


$routes->get('/save', function () {
    return view('save');
});
