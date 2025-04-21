<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\SocialAuthController;


// ✅ User Authentication & Profile Management
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users')->middleware('can:show_users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete')->middleware('can:delete_users');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');

// ✅ Product Management (For Employees & Admin)
Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit')->middleware('can:edit_products');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete')->middleware('can:delete_products');

// ✅ Purchase Product (For Customers)
Route::post('/products/{product}/purchase', [ProductsController::class, 'purchase'])->name('products.purchase');
Route::get('/my-orders', [ProductsController::class, 'myOrders'])->name('products.myOrders');


// Show form to create a new user (admin only)
Route::get('users/create', [UsersController::class, 'create'])->name('users_create')->middleware('can:admin_users');

// Save new user
Route::post('users/create', [UsersController::class, 'store'])->name('users_store')->middleware('can:admin_users');


// Route::post('/products/{product}/purchase', [ProductsController::class, 'purchase'])->name('products.purchase');


Route::get('/customers', [UsersController::class, 'listCustomers'])->name('customers.list');
Route::post('/customers/{id}/charge-credit', [UsersController::class, 'chargeCredit'])->name('customers.charge-credit');

Route::get('verify', [UsersController::class, 'verify'])->name('verify');
// routes/web.php



Route::get('/auth/google/redirect', [UsersController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [UsersController::class, 'handleGoogleCallback']);





Route::get('/my-orders', [ProductsController::class, 'myOrders'])->name('orders.my');

Route::middleware(['auth:web', 'can:list_orders'])->group(function () {
    // Route for Admin to view all orders
    Route::get('/orders', [ProductsController::class, 'listOrders'])->name('orders.list');
    Route::patch('/orders/{orderId}/update-status', [ProductsController::class, 'updateStatus'])->name('orders.updateStatus');
});



// Show form to request password reset
Route::get('/forgot-password', [UsersController::class, 'showForgotForm'])->name('password.request');

// Handle request and send email
Route::post('/forgot-password', [UsersController::class, 'sendResetLink'])->name('password.email');

// Show reset form
Route::get('/reset-password/{token}', [UsersController::class, 'showResetForm'])->name('password.reset');

// Handle password reset
Route::post('/reset-password', [UsersController::class, 'resetPassword'])->name('password.update');




Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);


Route::get('/auth/github/redirect', [UsersController::class, 'redirectToGithub'])->name('github.redirect');
Route::get('/auth/github/callback', [UsersController::class, 'handleGithubCallback']);


// ✅ Home Page & Test Views
Route::get('/', function () {
    return view('welcome');
});
Route::get('/multable', function (Request $request) {
    $j = $request->number ?? 5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
});
Route::get('/even', function () {
    return view('even');
});
Route::get('/prime', function () {
    return view('prime');
});



