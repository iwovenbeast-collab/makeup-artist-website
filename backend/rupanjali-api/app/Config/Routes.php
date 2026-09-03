<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->options('(:any)', function () {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setStatusCode(200);
});
$routes->get('/', 'Home::index');
$routes->group('api', function ($routes) {

    $routes->post('bookings', 'BookingController::store');
    $routes->get('bookings', 'BookingController::index');

    $routes->get('availability', 'AvailabilityController::index');
    $routes->post('availability', 'AvailabilityController::store');
    $routes->put('availability/(:num)', 'AvailabilityController::update/$1');
    $routes->delete('availability/(:num)', 'AvailabilityController::delete/$1');

    $routes->get('blogs', 'Api\BlogController::index');
    $routes->get('blogs/(:segment)', 'Api\BlogController::show/$1');

    $routes->get('portfolio', 'Api\PortfolioController::index');
    $routes->get('services', 'Api\ServiceController::index');
    
});

$routes->group('admin', function ($routes) {

    // Authentication
    $routes->get('login', 'Admin\AuthController::login');
    $routes->post('login', 'Admin\AuthController::attemptLogin');
    $routes->get('logout', 'Admin\AuthController::logout');

    // Dashboard
    $routes->get('dashboard', 'Admin\DashboardController::index');

    // Blogs
    $routes->get('blogs', 'Admin\BlogController::index');
    $routes->get('blogs/create', 'Admin\BlogController::create');
    $routes->post('blogs/store', 'Admin\BlogController::store');

    $routes->get(
        'blogs/edit/(:num)',
        'Admin\BlogController::edit/$1'
    );

    $routes->post(
        'blogs/update/(:num)',
        'Admin\BlogController::update/$1'
    );

    $routes->get(
        'blogs/delete/(:num)',
        'Admin\BlogController::delete/$1'
    );

    // Blog gallery
    $routes->post(
        'blogs/(:num)/images',
        'Admin\BlogController::uploadImages/$1'
    );

    $routes->get(
        'blogs/images/delete/(:num)',
        'Admin\BlogController::deleteImage/$1'
    );

    $routes->get('availability', 'Admin\AvailabilityController::index');
    $routes->post('availability/store', 'Admin\AvailabilityController::store');
    $routes->get('availability/delete/(:num)', 'Admin\AvailabilityController::delete/$1');

        // Bookings
    $routes->get(
        'bookings',
        'Admin\BookingController::index'
    );

    $routes->get(
        'bookings/confirm/(:num)',
        'Admin\BookingController::confirm/$1'
    );

    $routes->get(
        'bookings/cancel/(:num)',
        'Admin\BookingController::cancel/$1'
    );

    $routes->get(
        'bookings/create',
        'Admin\BookingController::create'
    );

    $routes->post(
        'bookings/store',
        'Admin\BookingController::store'
    );

        // Portfolio
    $routes->get('admin/portfolio', 'Admin\PortfolioController::index');
    $routes->get('portfolio', 'Admin\PortfolioController::index');
    $routes->get('portfolio/create', 'Admin\PortfolioController::create');
    $routes->post('portfolio/store', 'Admin\PortfolioController::store');
    $routes->get('portfolio/edit/(:num)', 'Admin\PortfolioController::edit/$1');
    $routes->post('portfolio/update/(:num)', 'Admin\PortfolioController::update/$1');
    $routes->get('portfolio/delete/(:num)', 'Admin\PortfolioController::delete/$1');

    $routes->get('services', 'Admin\ServiceController::index');
    $routes->get('services/create', 'Admin\ServiceController::create');
    $routes->post('services/store', 'Admin\ServiceController::store');
    $routes->get('services/edit/(:num)', 'Admin\ServiceController::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\ServiceController::update/$1');
    $routes->get('services/delete/(:num)', 'Admin\ServiceController::delete/$1');

});
