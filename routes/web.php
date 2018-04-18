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
    if (Auth::check()) {
        return view('welcome');
    } else {
        return redirect('/auth/login');
    }
});

Auth::routes();

Route::get('/login', function() {
    return redirect('/auth/login');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auth', array('uses' => 'Admin\LoginController@index'));
Route::get('/auth/login', array('uses' => 'Admin\LoginController@login'));
Route::post('/auth/logout', array('uses' => 'Admin\LoginController@logout'));
Route::post('/auth/checklogin', array('uses' => 'Admin\LoginController@checkLogin'));

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@index');
    Route::get('/monitoring', 'BackendController@monitoring');
    Route::get('/users', 'BackendController@monitoring');
    Route::get('/masters', 'BackendController@masters');
    Route::get('/settings', 'BackendController@settings');
});
