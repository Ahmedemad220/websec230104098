<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function () {
    return view('multable');
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime'); 
});

Route::get('/minitest', function () {
 $bill = [
     ['item' => 'Apples', 'quantity' => 2, 'price' => 3.50],
     ['item' => 'Milk', 'quantity' => 1, 'price' => 4.00],
     ['item' => 'Bread', 'quantity' => 1, 'price' => 2.50],
     ['item' => 'Eggs', 'quantity' => 12, 'price' => 5.00],
     ['item' => 'Chicken', 'quantity' => 1, 'price' => 8.75],
 ];

    return view('minitest', compact('bill'));
});

      