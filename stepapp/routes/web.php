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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/register', function () {
    return view('auth/register');
});
Route::get('/login', function () {
    return view('auth/login');
});
Route::get('/reminder', function () {
    return view('auth/passwords/email');
});
Route::get('/reset', function () {
    return view('auth/passwords/reset');
});
Route::get('/auth_key', function () {
    return view('auth/passwords/auth_key');
});

Route::get('/new_step', function () {
    return view('step/new_step');
});
Route::get('/edit_step', function () {
    return view('step/edit_step');
});
Route::get('/new_child', function () {
    return view('step/new_child');
});
