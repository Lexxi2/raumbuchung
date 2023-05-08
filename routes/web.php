<?php

use App\Models\Admin;
use LdapRecord\Models\OpenLDAP\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use LdapRecord\Models\FreeIPA\User as FreeIPAUser;

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
    // ddd(User::all());  // LDAPRecord
    ddd(FreeIPAUser::find(['uid' => 'schneideralexa']));

    ddd(App\Models\User::all()->first());
});

// Route::get('/', function () {
//     return view('pages.dashboard.index');
// });


// Auth routes
Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',       [LoginController::class, 'login'])->name('login');
Route::get ('/logout',      [LoginController::class, 'logout'])->name('logout');
Route::post ('/logout',      [LoginController::class, 'logout'])->name('logout');


// Routes for Auth
Route::middleware(['web', 'auth:web'])->group(function() {

    // Dashboard
    Route::get('/dashboard',   [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/{room}',   [DashboardController::class, 'show'])->name('dashboard.show');
    // neue Buchungen
    Route::post('/dashboard/store',    [DashboardController::class, 'store'])->name('dashboard.store');

    // Admin
    Route::get('/index',    [RoomController::class, 'index'])->name('room.index');
    Route::get('/create',    [RoomController::class, 'create'])->name('room.create');
    Route::post('/store',    [RoomController::class, 'store'])->name('room.store');
    Route::post('/update/{id}',    [RoomController::class, 'update'])->name('room.update');
    Route::get('/edit/{username}',    [RoomController::class, 'edit'])->name('room.edit');
    Route::delete('/delete/{id}',    [RoomController::class, 'destroy'])->name('room.destroy');


});

