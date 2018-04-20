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
})->name('login');;

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auth', array('uses' => 'Admin\LoginController@index'));
Route::get('/auth/login', array('uses' => 'Admin\LoginController@login'));
Route::post('/auth/logout', array('uses' => 'Admin\LoginController@logout'));
Route::post('/auth/checklogin', array('uses' => 'Admin\LoginController@checkLogin'));

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/monitoring', 'BackendController@monitoring')->name('monitoring');
    Route::post('/monitoring', 'BackendController@monitoring')->name('monitoring');
    Route::get('/monitoring/detail/{id}', 'BackendController@detail')->name('monitoring_detail');
    Route::get('/users', 'BackendController@users')->name('users');
    Route::get('/users/edit/{id}', 'BackendController@editUser')->name('users');
    Route::get('/masters', 'BackendController@masters')->name('masters');
    Route::get('/masters/edit/{id}', 'BackendController@masterEdit')->name('masters_edit');
    Route::get('/settings', 'BackendController@settings')->name('settings');
});
