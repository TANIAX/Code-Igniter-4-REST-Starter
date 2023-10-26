<?php

namespace Config;

use App\Controllers\IndividuController;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('SwaggerController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


//! WEB ROUTES
$routes->get('/', 'SwaggerController::index');


//! API ROUTES
$routes->group('api/v1', static function ($routes) {
    $routes->setDefaultNamespace('App\Controllers\API\V1');

    ///? Auth
    $routes->group('auth', static function ($routes) {
        $routes->post('login', 'AuthController::Login');
    });

    //? Todo
    $routes->group('todo' , ['filter' => 'auth'] ,static function($routes){
        $routes->get('', 'TodoController::index');
        $routes->get('(:num)', 'TodoController::show/$1');
        $routes->post('', 'TodoController::create');
        $routes->put('', 'TodoController::update');
        $routes->delete('(:num)', 'TodoController::delete/$1');
    });
});





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
