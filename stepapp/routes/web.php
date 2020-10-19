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
// ＝＝＝＝＝＝＝＝＝＝＝＝　ユーザー登録画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/register', function () {
    return view('auth/register');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　ログイン画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/login', function () {
    return view('auth/login');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　パスワード再発行先メアド入力画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/reminder', function () {
    return view('auth/passwords/email');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　パスワード再設定画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/reset', function () {
    return view('auth/passwords/reset');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　認証キー入力画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/auth_key', function () {
    return view('auth/passwords/auth_key');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　プロフィール画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/profile', function () {
    return view('step/profile');
});

// ＝＝＝＝＝＝＝＝＝＝＝＝　STEP登録画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/new_step', function () {
    return view('step/new_step');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　STEP編集画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/edit_step', function () {
    return view('step/edit_step');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　子STEP登録画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/new_child', function () {
    return view('step/new_child');
});

// ＝＝＝＝＝＝＝＝＝＝＝＝　STEP一覧画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/step_list', function () {
    return view('step/step_list');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　マイページ画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/mypage', function () {
    return view('step/mypage');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　STEP詳細画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/step_detail', function () {
    return view('step/step_detail');
});
// ＝＝＝＝＝＝＝＝＝＝＝＝　子STEP詳細画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/child_detail', function () {
    return view('step/child_detail');
});

// ＝＝＝＝＝＝＝＝＝＝＝＝　TOP画面表示　＝＝＝＝＝＝＝＝＝＝＝＝
Route::get('/top', function () {
    return view('step/top');
});