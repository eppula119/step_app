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
Route::get('/step_list', 'StepController@showStepList')->name('steps.show'); // STEP一覧
Route::get('/step_list/{id}', 'StepController@showStepDetail')->name('step_detail.show'); // STEP詳細

Route::post('/register', 'Auth\RegisterController@register')->name('register'); //ユーザー登録
Route::post('/login', 'Auth\LoginController@login')->name('login'); //ログイン
Route::post('/logout', 'Auth\LoginController@logout')->name('logout'); //ログアウト
Route::post('/forgot', 'Auth\ForgotPasswordController@forgot')->name('forgot'); //パスワードリマインダー
Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('reset'); // パスワードリセット

Route::post('/register_step', 'StepController@registerStep')->name('step.register');; // STEP登録
Route::post('/register_child', 'StepController@registerChild')->name('child.register');; // 子STEP登録
Route::post('/category/search', 'StepController@indexCategory'); // 各カテゴリー取得