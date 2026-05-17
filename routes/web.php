<?php

/**
 * Dtrans Rental — Web Routes
 * All HTTP routes are registered here
 *
 * Syntax: $router->get('uri', 'ControllerName@method', ['middleware']);
 *         $router->post('uri', 'ControllerName@method', ['middleware']);
 *         $router->group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function($r) { ... });
 */

/** @var Router $router */
$router = $this;

// ============================================================
// Public Routes
// ============================================================

$router->get('/',              'HomeController@index');
$router->get('/cars',          'CarController@index');
$router->get('/cars/{id}',     'CarController@show');
$router->get('/tourism',       'TourismController@index');
$router->get('/tourism/{id}',  'TourismController@show');
$router->get('/drivers',       'DriverController@publicIndex');

// ============================================================
// Authentication Routes
// ============================================================

$router->group(['prefix' => '/auth'], function ($r) {
    $r->get('/login',                    'AuthController@loginForm');
    $r->post('/login',                   'AuthController@login');
    $r->get('/register',                 'AuthController@registerForm');
    $r->post('/register',                'AuthController@register');
    $r->get('/logout',                   'AuthController@logout');
    $r->get('/verify/{token}',           'AuthController@verifyEmail');
    $r->get('/forgot-password',          'AuthController@forgotForm');
    $r->post('/forgot-password',         'AuthController@sendReset');
    $r->get('/reset-password/{token}',   'AuthController@resetForm');
    $r->post('/reset-password',          'AuthController@resetPassword');

    // Google OAuth
    $r->get('/google',                   'GoogleAuthController@redirect');
    $r->get('/google/callback',          'GoogleAuthController@callback');
});

// ============================================================
// Customer Routes (authenticated)
// ============================================================

$router->group(['prefix' => '/customer', 'middleware' => ['auth']], function ($r) {
    $r->get('/dashboard',                'CustomerController@dashboard');
    $r->get('/profile',                  'CustomerController@profile');
    $r->post('/profile',                 'CustomerController@updateProfile');

    // Bookings
    $r->get('/bookings',                 'BookingController@index');
    $r->get('/bookings/create',          'BookingController@create');
    $r->post('/bookings/store',          'BookingController@store');
    $r->get('/bookings/{id}',            'BookingController@show');
    $r->post('/bookings/{id}/cancel',    'BookingController@cancel');

    // Payment
    $r->get('/bookings/{id}/pay',        'PaymentController@show');
    $r->post('/bookings/{id}/pay',       'PaymentController@process');
    $r->post('/payment/midtrans/notify', 'PaymentController@midtransNotify');

    // Invoice
    $r->get('/bookings/{id}/invoice',    'InvoiceController@download');

    // Driver rating
    $r->post('/bookings/{id}/review',    'BookingController@submitReview');

    // Live chat
    $r->get('/chat',                     'ChatController@index');
    $r->get('/chat/messages',            'ChatController@fetch');
    $r->post('/chat/send',               'ChatController@send');
});

// ============================================================
// Driver Routes (authenticated, driver role)
// ============================================================

$router->group(['prefix' => '/driver', 'middleware' => ['auth', 'driver']], function ($r) {
    $r->get('/dashboard',                'DriverDashboardController@index');
    $r->get('/bookings',                 'DriverDashboardController@bookings');
    $r->post('/bookings/{id}/accept',    'DriverDashboardController@accept');
    $r->post('/bookings/{id}/reject',    'DriverDashboardController@reject');
    $r->get('/availability',             'DriverDashboardController@availability');
    $r->post('/availability',            'DriverDashboardController@updateAvailability');
    $r->get('/profile',                  'DriverDashboardController@profile');
    $r->post('/profile',                 'DriverDashboardController@updateProfile');
});

// ============================================================
// Admin Routes (authenticated, admin role)
// ============================================================

$router->group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function ($r) {
    $r->get('/dashboard',                'AdminController@dashboard');

    // Cars
    $r->get('/cars',                     'AdminCarController@index');
    $r->get('/cars/create',              'AdminCarController@create');
    $r->post('/cars/store',              'AdminCarController@store');
    $r->get('/cars/{id}/edit',           'AdminCarController@edit');
    $r->post('/cars/{id}/update',        'AdminCarController@update');
    $r->post('/cars/{id}/delete',        'AdminCarController@delete');

    // Drivers
    $r->get('/drivers',                  'AdminDriverController@index');
    $r->get('/drivers/create',           'AdminDriverController@create');
    $r->post('/drivers/store',           'AdminDriverController@store');
    $r->get('/drivers/{id}/edit',        'AdminDriverController@edit');
    $r->post('/drivers/{id}/update',     'AdminDriverController@update');
    $r->post('/drivers/{id}/delete',     'AdminDriverController@delete');

    // Bookings
    $r->get('/bookings',                 'AdminBookingController@index');
    $r->get('/bookings/{id}',            'AdminBookingController@show');
    $r->post('/bookings/{id}/approve',   'AdminBookingController@approve');
    $r->post('/bookings/{id}/reject',    'AdminBookingController@reject');
    $r->post('/bookings/{id}/complete',  'AdminBookingController@complete');

    // Customers
    $r->get('/customers',                'AdminCustomerController@index');
    $r->get('/customers/{id}',           'AdminCustomerController@show');

    // Tourism
    $r->get('/tourism',                  'AdminTourismController@index');
    $r->get('/tourism/create',           'AdminTourismController@create');
    $r->post('/tourism/store',           'AdminTourismController@store');
    $r->get('/tourism/{id}/edit',        'AdminTourismController@edit');
    $r->post('/tourism/{id}/update',     'AdminTourismController@update');
    $r->post('/tourism/{id}/delete',     'AdminTourismController@delete');

    // Reports
    $r->get('/reports',                  'AdminReportController@index');
    $r->get('/reports/export',           'AdminReportController@export');

    // Live chat (admin side)
    $r->get('/chat',                     'AdminChatController@index');
    $r->get('/chat/{customerId}/messages', 'AdminChatController@fetch');
    $r->post('/chat/{customerId}/send',  'AdminChatController@send');

    // Activity logs
    $r->get('/logs',                     'AdminLogController@index');
});

// ============================================================
// AJAX / API Routes
// ============================================================

$router->group(['prefix' => '/api'], function ($r) {
    $r->get('/cars/availability',        'ApiController@carAvailability');
    $r->get('/drivers/available',        'ApiController@availableDrivers');
    $r->post('/booking/calculate',       'ApiController@calculateBooking');
});

// ============================================================
// Error Routes
// ============================================================

$router->get('/403', 'ErrorController@forbidden');
$router->get('/404', 'ErrorController@notFound');
$router->get('/500', 'ErrorController@serverError');
