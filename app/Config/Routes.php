<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ── Public Routes ─────────────────────────────────────────────────
$routes->get('/',                        'Home::index');
$routes->get('home',                     'Home::index');

// Products
$routes->get('category/(:segment)',      'ProductController::category/$1');
//$routes->get('categories', 'Admin\CategoriesController::index');
$routes->get('product/(:segment)',       'ProductController::detail/$1');

// Search
$routes->get('search',                   'SearchController::index');

// Auth
$routes->get('login',                    'AuthController::index');
$routes->get('register',                 'AuthController::index');
$routes->post('auth/login',              'AuthController::login');
$routes->post('auth/register',           'AuthController::register');
$routes->get('auth/logout',              'AuthController::logout');
$routes->get('auth/check-email',         'AuthController::checkEmail');

// Cart (AJAX + page)
$routes->get('cart',                     'CartController::index');
$routes->post('cart/add',                'CartController::add');
$routes->post('cart/update',             'CartController::update');
$routes->post('cart/remove',             'CartController::remove');
$routes->get('cart/count',               'CartController::count');
$routes->post('cart/apply-coupon',       'CartController::applyCoupon');

// Checkout
$routes->get('checkout',                 'CheckoutController::index',    ['filter' => 'auth']);
$routes->post('checkout/place-order',    'CheckoutController::placeOrder',['filter' => 'auth']);
//$routes->get('checkout/success/(:num)', 'CheckoutController::success/$1',['filter' => 'auth']);
$routes->get('checkout/success/(:num)', 'CheckoutController::success/$1', ['filter' => 'auth']);

// Profile
$routes->get('profile',                  'ProfileController::index',     ['filter' => 'auth']);
$routes->post('profile/update',          'ProfileController::update',    ['filter' => 'auth']);
$routes->post('profile/change-password', 'ProfileController::changePassword',['filter'=>'auth']);
$routes->get('profile/orders',           'ProfileController::orders',    ['filter' => 'auth']);
$routes->get('profile/wishlist',         'ProfileController::wishlist',  ['filter' => 'auth']);

// Wishlist AJAX
$routes->post('wishlist/toggle',         'ProfileController::toggleWishlist',['filter'=>'auth']);

// Contact
$routes->get('contact',                  'ContactController::index');
$routes->post('contact/send',            'ContactController::send');

// Newsletter
$routes->post('newsletter/subscribe',    'Home::subscribe');

// ── Admin Routes ───────────────────────────────────────────────────
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('/',                    'Admin\DashboardController::index');
    $routes->get('dashboard',            'Admin\DashboardController::index');
    $routes->get('chart-data',           'Admin\DashboardController::chartData');

    // Products
    $routes->get('products',             'Admin\ProductsController::index');
    $routes->post('products/store',      'Admin\ProductsController::store');
    $routes->post('products/update/(:num)','Admin\ProductsController::update/$1');
    $routes->post('products/delete/(:num)','Admin\ProductsController::delete/$1');
    $routes->get('products/get/(:num)',  'Admin\ProductsController::get/$1');
    $routes->post('products/upload-image','Admin\ProductsController::uploadImage');

    // Orders
    $routes->get('orders',               'Admin\OrdersController::index');
    $routes->get('orders/get/(:num)',    'Admin\OrdersController::get/$1');
    $routes->post('orders/update-status','Admin\OrdersController::updateStatus');
    $routes->get('orders/export-csv',    'Admin\OrdersController::exportCsv');

    // Users
    $routes->get('users',                'Admin\UsersController::index');
    $routes->post('users/toggle/(:num)', 'Admin\UsersController::toggle/$1');

    // Coupons
    $routes->get('coupons',              'Admin\CouponsController::index');
    $routes->post('coupons/store',       'Admin\CouponsController::store');
    $routes->post('coupons/delete/(:num)','Admin\CouponsController::delete/$1');

    // Messages
    $routes->get('messages',             'Admin\MessagesController::index');
    $routes->post('messages/toggle-read/(:num)','Admin\MessagesController::toggleRead/$1');
});

// Admin login (public)
$routes->get('admin/login',              'Admin\DashboardController::login');
$routes->post('admin/login',             'Admin\DashboardController::doLogin');