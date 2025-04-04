<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;

// ✅ User Authentication & Profile Management
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');

// ✅ Product Management (For Employees & Admin)
Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

// ✅ Purchase Product (For Customers)
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/products/{product}/purchase', [ProductsController::class, 'purchase'])->name('products.purchase');
    Route::get('/my-orders', [ProductsController::class, 'myOrders'])->name('products.myOrders');
});



Route::post('users/{user}/add-credit', [UsersController::class, 'addCredit'])->name('users_add_credit')->middleware('auth');


// ✅ Employee Actions (Manage Customers)
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/customers', [ProductsController::class, 'listCustomers'])->name('employees.listCustomers');
    Route::post('/customers/{customer}/add-credit', [ProductsController::class, 'addCredit'])->name('employees.addCredit');
});

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
