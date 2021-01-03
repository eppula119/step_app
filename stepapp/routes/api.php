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
Route::get('/step_list/step={step_id}/child', 'StepController@showChild')->name('child.show'); // 子STEP詳細
Route::get('/mypage', 'StepController@showMypage')->name('mypage.show'); // マイページ
Route::get('/profile', 'StepController@showProfile')->name('profile.show'); // プロフィール編集画面

Route::post('/register', 'Auth\RegisterController@register')->name('register'); //ユーザー登録
Route::post('/login', 'Auth\LoginController@login')->name('login'); //ログイン
Route::post('/logout', 'Auth\LoginController@logout')->name('logout'); //ログアウト
Route::post('/forgot', 'Auth\ForgotPasswordController@forgot')->name('forgot'); //パスワードリマインダー
Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('reset'); // パスワードリセット

Route::post('/register_step', 'StepController@registerStep')->name('step.register');; // STEP登録
Route::post('/register_child', 'StepController@registerChild')->name('child.register');; // 子STEP登録
Route::post('/update_step/{id}', 'StepController@updateStep')->name('step.update'); // STEP編集
Route::post('/update_child/{id}', 'StepController@updateChild')->name('child.update'); // 子STEP編集
Route::post('/update_profile', 'StepController@updateProfile')->name('profile.update'); // プロフィール登録・編集
Route::post('/category/search', 'StepController@indexCategory'); // 各カテゴリー取得
Route::post('/challenge/{id}', 'StepController@challenge'); // チャレンジする
Route::post('/clear/{id}', 'StepController@clear'); // クリアする

Route::put('/step_list/{id}/favorite', 'StepController@favorite')->name('idea.favorite'); // お気に入り登録
Route::delete('/step_list/{id}/favorite', 'StepController@unfavorite'); //　お気に入り解除
