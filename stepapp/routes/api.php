<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/user', 'StepController@isLogin')->name('user'); // ログインユーザー

Route::post('/register', 'Auth\RegisterController@register')->name('register'); //ユーザー登録
Route::post('/login', 'Auth\LoginController@login')->name('login'); //ログイン
Route::post('/logout', 'Auth\LoginController@logout')->name('logout'); //ログアウト
Route::post('/forgot', 'Auth\ForgotPasswordController@forgot')->name('forgot'); //パスワードリマインダー
Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('reset'); // パスワードリセット
Route::post('/register_step', 'StepController@registerStep')->name('step.register');; // STEP登録