<?php

use App\Http\Controllers\CourtController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::resource('reservation', ReservationController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('court', CourtController::class);
    Route::resource('user', UserController::class);

    Route::put('/user/{user}/deleteUserImage', [UserController::class, 'deleteUserImage'])->name('delete_user_image');
    Route::get('/storage/app/user/{id}/{filename}', [StorageController::class, 'get'])->name('get_user_image');
    Route::get('/storage/app/logo/{id}', [StorageController::class, 'getLogo'])->name('get_logo_image');
    Route::put('/user/{user}/saveUserImage', [UserController::class, 'saveUserImage'])->name('save_user_image');

    Route::get('/setting/{club}/getLatestReservation', [SettingController::class, 'getLatestReservation'])->name('get_latest_reservation');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
