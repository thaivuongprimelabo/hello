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

Route::group(['prefix' => 'auth', 'namespace' => 'Admin'], function () {
    Route::get('/', array('uses' => 'LoginController@index'));
    Route::get('/login', array('uses' => 'LoginController@login'));
    Route::post('/logout', array('uses' => 'LoginController@logout'));
    Route::post('/checklogin', array('uses' => 'LoginController@checkLogin'));
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    #Monitoring
    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('/', 'BackendController@monitoring')->name('monitoring');
        Route::post('/', 'BackendController@monitoring')->name('monitoring');
        Route::get('/detail/{id}', 'BackendController@detail')->name('monitoring_detail');
    });

    #Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'BackendController@users')->name('users');
        Route::get('/edit/{id}', 'BackendController@editUser')->name('users');
    });

    #Masters
    Route::group(['prefix' => 'masters'], function () {
        Route::get('/', 'BackendController@masters')->name('masters');
        Route::get('/edit/{id}', 'BackendController@masterEdit')->name('masters_edit');
    });

    #Settings
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'BackendController@settings')->name('settings');
        Route::post('/', 'BackendController@settings')->name('settings');
    });

});
