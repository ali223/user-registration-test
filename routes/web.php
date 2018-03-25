<?php

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

Route::get('/', 'UsersController@showLoginForm')->middleware('guest');

Route::get('/login', 'UsersController@showLoginForm')->middleware('guest');
Route::post('/login', 'UsersController@login')->name('login');

Route::get('/logout', 'UsersController@logout')->name('logout')->middleware('auth');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');

Route::get('activate', 'UsersController@activate');





