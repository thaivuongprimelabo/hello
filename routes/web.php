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
        Route::post('/detail/{id}', 'BackendController@updateMonitoring');
        Route::get('/back/{condition}', 'BackendController@back');
    });

    #Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'BackendController@users')->name('users');
        Route::get('/edit/{id}', 'BackendController@usersEdit')->name('users_edit');
        Route::post('/edit/{id}', 'BackendController@usersEdit')->name('users_edit');
        Route::get('/new', 'BackendController@usersNew')->name('users_new');
        Route::post('/new', 'BackendController@usersNew')->name('users_new');
        Route::post('/coundLoginId', 'BackendController@coundLoginId')->name('users_cound_loginid');
        Route::post('/lockUser', 'BackendController@lockUser')->name('users_lockuser');
    });

    #Masters
    Route::group(['prefix' => 'masters'], function () {
        Route::get('/', 'BackendController@masters')->name('masters');
        Route::get('/edit/{id}', 'BackendController@masterEdit')->name('masters_edit');
        Route::post('/edit/{id}', 'BackendController@masterEdit')->name('masters_edit');
        Route::get('/new', 'BackendController@masterNew')->name('masters_new');
        Route::post('/new', 'BackendController@masterNew')->name('masters_new');
        Route::post('/countPhoneNumber', 'BackendController@countPhoneNumber')->name('masters_count_phone_number');
    });

    #Settings
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'BackendController@settings')->name('settings');
	Route::post('/', 'BackendController@settings');
    });

});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
    if (env('APP_ENV') == 'local') {
        Route::get('/', 'ApiController@index')->name('myAuthenticate');
    }
    
    Route::get('/twilio/call', 'ApiController@twilioCallTest')->name('myAuthenticate');
    
    Route::get('/twilio/call/{id}', 'ApiController@twilioCall')->name('myAuthenticate');
    Route::post('/twilio/call/{id}', 'ApiController@twilioCall')->name('myAuthenticate');
    
    Route::get('/{a}/{b}', 'ApiController@notfound')->name('myAuthenticate');
    Route::post('/my/authenticate', 'ApiController@myAuthenticate')->name('myAuthenticate');
    Route::post('/calls/create', 'ApiController@callCreate')->name('myAuthenticate');
    Route::post('/calls/cancel', 'ApiController@callCancel')->name('myAuthenticate');
    Route::post('/calls/status', 'ApiController@callStatus')->name('myAuthenticate');
    Route::post('/calls/search', 'ApiController@callSearch')->name('myAuthenticate');

    Route::get('/twilio/makecall/{id}', 'ApiController@makeCall')->name('myAuthenticate');
    Route::get('/twilio/stopcall/{id}', 'ApiController@stopCall')->name('myAuthenticate');
    Route::get('/twilio/status-event/{id}', 'ApiController@twilioStatusEvent')->name('myAuthenticate');
    Route::post('/twilio/status-event/{id}', 'ApiController@twilioStatusEvent')->name('myAuthenticate');

});
