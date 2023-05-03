<?php

use App\Http\Controllers\Auth\LoginController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/ldap', function () {
    ddd(App\Models\User::all());
});

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route::group(['middleware' => 'auth'], function () {
//     Route::get('/', function () {
//         return view('index');
//     });   
// });

// Auth routes
Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',       [LoginController::class, 'login'])->name('login');
    Route::get ('/logout',      [LoginController::class, 'logout'])->name('logout');


// Routes for Admins only
Route::middleware(['web', 'auth:web'])->group(function() {

    Route::get('/test', function () {
        return view('test'); })->name('test');

});

