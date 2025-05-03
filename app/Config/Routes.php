<?php

use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;
use App\Controllers\News;
use App\Controllers\ContactController;
use App\Controllers\RegisterController;

use App\Controllers\LoginController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');



// $routes->get('Home', [Home::class, 'index']);
// $routes->get('view1', [Home::class,'view1']);
// $routes->get('view', [Home::class, 'view']);
$routes->get('Home', [Home::class, 'all']);


$routes->get('news', [News::class, 'index']);
$routes->get('news/(:segment)', [News::class, 'show']);

//contacts
$routes->get('/contact', [ContactController::class, 'index']);
$routes->post('/contact/submit', [ContactController::class, 'submit']);
$routes->get('/contact/view', [ContactController::class, 'view']);

//register
$routes->get('/register', [RegisterController::class, 'index']);
$routes->post('/register/submit', [RegisterController::class, 'submit']);

//login
$routes->get('/login', 'LoginController::index');
$routes->post('/login/submit', 'LoginController::submit');
$routes->get('/logout', 'LoginController::logout');

// User dashboard
$routes->get('/dashboard', function () {
    if (!session()->get('isLoggedIn') || session()->get('isAdmin')) {
        return redirect()->to('/login');
    }
    return "Welcome, " . session()->get('user_name') . "! <a href='" . site_url('logout') . "'>Logout</a>";
});

// Admin dashboard (user list)
$routes->get('/admin/users', 'AdminController::users');









//=======================================================================================================================//
//authenticate the login form
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

//admin login
$routes->get('/admin/dashboard', 'AdminController::dashboard');
// Admin - Menu management
$routes->get('menu/adminIndex', 'MenuController::menu');
$routes->get('menu/index', 'MenuController::index');
$routes->get('menu/create', 'MenuController::create');
$routes->post('menu/store', 'MenuController::store');
$routes->get('menu/edit/(:num)', 'MenuController::edit/$1');
$routes->post('menu/update/(:num)', 'MenuController::update/$1');
$routes->get('menu/delete/(:num)', 'MenuController::delete/$1');
$routes->get('/order/view/(:num)', 'OrderController::viewOrder/$1');
$routes->post('menu/filter', 'MenuController::filter');

$routes->get('menu/loadAll', 'MenuController::loadAll');
$routes->get('/menu/category/(:segment)', 'MenuController::category/$1');





$routes->get('/orders', 'OrderController::index');
$routes->get('/order', 'OrderController::index');                  // View all orders
$routes->get('/order/create', 'OrderController::create');          // Show order form
$routes->post('/order/store', 'OrderController::store');           // Save new order
$routes->get('/order/edit/(:num)', 'OrderController::edit/$1');    // Edit order form
$routes->post('/order/update/(:num)', 'OrderController::update/$1'); // Update order
$routes->get('/order/delete/(:num)', 'OrderController::delete/$1');  // Delete order

$routes->post('/orders/update-status/(:num)', 'OrderController::updateStatus/$1');
$routes->get('homePage', 'HomeController::menu');

//customer login, logout, register
$routes->get('customer/register', 'CustomerController::register');
$routes->post('customer/store', 'CustomerController::store');
$routes->get('/customer/login', 'CustomerController::login');
$routes->post('/customer/authenticate', 'CustomerController::authenticate');
$routes->get('/customer/logout', 'CustomerController::logout');

//forgot password--customer
$routes->get('customer/reset_password', 'CustomerController::showResetPasswordForm');
$routes->post('customer/reset_password', 'CustomerController::handleResetPassword');



$routes->get('customer/forgot_password', 'CustomerController::forgot_password');

$routes->post('customer/send', 'CustomerController::send');

$routes->get('customer/reset_password', 'CustomerController::reset_password');
$routes->post('customer/reset_password', 'CustomerController::reset_password');



//regular homePage
$routes->get('about', 'HomeController::about');
$routes->get('contactR', 'HomeController::contactR');



$routes->group('', ['filter' => 'auth'], static function ($routes) {

    // Order management
    $routes->get('order/create/(:num)', 'OrderController::create/$1');
    $routes->post('order/submit', 'OrderController::submit');

    //Customer
    $routes->get('/customer/dashboard', 'CustomerController::dashboard'); // Optional

    $routes->get('/customer/customer_dashboard', 'CustomerController::dashboard');
    $routes->get('/customer/orders', 'CustomerController::orders');
    $routes->get('customer/notifications', 'CustomerController::notifications');


    //notification
    // $routes->post('/orders/update-status/(:segment)', 'OrderController::updateNotificationStatus/$1');
    // $routes->get('/customer/fetchNotifications', 'NotificationController::fetchNotifications');
    // $routes->post('/customer/markAsRead/(:segment)', 'NotificationController::markAsRead/$1');

    $routes->get('/customer/fetchNotifications', 'CustomerController::fetchNotifications');
    $routes->post('/customer/markNotificationRead', 'CustomerController::markNotificationRead');




    $routes->get('/menu', 'MenuController::index');
    $routes->get('/customer/orders', 'OrderController::index');

    //invoice download
    $routes->get('/order/invoice/(:segment)', 'OrderController::invoices/$1');
    $routes->get('/customer/download_invoice/(:segment)', 'OrderController::download_invoice/$1');
    $routes->get('/customer/invoices', 'OrderController::invoices');
    $routes->get('/customer/invoices/(:num)', 'OrderController::viewOrder/$1');
    $routes->get('/order/invoice/(:num)', 'OrderController::viewOrder/$1');

    //CSRF 
    $routes->post('form/submit', 'FormController::submit', ['filter' => 'csrf']);

    // cart
    $routes->post('cart/add', 'CartController::addToCart');
    $routes->get('cart', 'CartController::index');
    $routes->get('cart/index', 'CartController::index');
    $routes->get('cart/checkout', 'CartController::checkout');
    $routes->get('cart/remove/(:num)', 'CartController::removeFromCart/$1');
    $routes->post('cart/update', 'CartController::update');

    $routes->get('cart/clear', 'CartController::clear');
});
