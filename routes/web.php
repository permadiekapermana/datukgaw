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

// Landing Page Routes
Route::get('/', 'AuthController@Login');
Route::get('/404', 'NotFoundController@NotFound');

// route login
Route::get('/login_process/{role}', 'AuthController@login_process');
Route::get('/login', 'AuthController@Login');

// CMS Routes
// route admin
Route::group(['middleware' => ['login.middleware', 'admin.middleware']], function() {
    Route::prefix('cms')->group(function () {
        Route::get('/users', 'UsersController@Users');
    });
});

// route all users
Route::group(['middleware' => ['login.middleware']], function() {
    Route::get('/cms', 'DashboardController@Cms');
    Route::get('/logout', 'AuthController@logout');
    Route::prefix('cms')->group(function () {
        Route::get('/dashboard', 'DashboardController@Dashboard');
        Route::get('/keuangan', 'KeuanganController@Keuangan');
        Route::get('/profile', 'UsersController@Profile');
        Route::get('/change-password', 'UsersController@Password');
    });
});