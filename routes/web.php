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

Route::get('/transcript', function () {
    $transcript = [
        ['course' => 'Operating Systems', 'credit' => 3, 'grade' => 'A'],
        ['course' => 'Web Development', 'credit' => 4, 'grade' => 'B+'],
        ['course' => 'Computer Networks', 'credit' => 3, 'grade' => 'A-'],
        ['course' => 'Cyber Security', 'credit' => 3, 'grade' => 'B'],
        ['course' => 'Machine Learning', 'credit' => 4, 'grade' => 'A'],
    ];

    return view('transcript', compact('transcript'));
});

use App\Http\Controllers\Web\ProductsController;

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

use App\Http\Controllers\GradesController;
Route::resource('grades', GradesController::class);

use App\Http\Controllers\QuestionController;
Route::resource('questions', QuestionController::class);
Route::get('exam/start', [QuestionController::class, 'startExam'])->name('exam.start');
Route::post('exam/submit', [QuestionController::class, 'submitExam'])->name('exam.submit');
Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('questions.edit');

use App\Http\Controllers\ProfileController;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', function () {
    return view('profile'); // Make sure profile.blade.php exists in resources/views
})->name('profile');


Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});



use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Redirect to login page after logout
})->name('logout');


