<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('home_index_page');
});


Route::group(['prefix' =>  '/auth'], function () {
    Route::get('/', 'AuthenticationController@actionHomeLogin')->name("login_page");
    Route::get('/login', "AuthenticationController@actionLoginTest")->name('login_rmuti_page');
    Route::get('/logout', "AuthenticationController@actionLogout")->name('logout_data');
});

Route::group(['prefix' => '/home', 'middleware' => [ ] ], function () {
    Route::get('/', "HomeController@actionIndex")->name('home_index_page');
});




Route::group(['prefix' => '/admin', 'middleware' => [ ] ], function () {

    Route::get('/', function () {
        return redirect()->route('dashboard_ad_index_page');
    });

    Route::group(['prefix' => '/dashboard'], function () {
        Route::get('/', "DashboardController@actionIndex")->name('dashboard_ad_index_page');
    });

    Route::group(['prefix' => '/topic'], function () {
        Route::get('/', "TopicController@actionIndex")->name('topic_ad_index_page');
        Route::get('/update/{id}', "TopicController@actionUpdate")->name('topic_ad_update_page');
        Route::get('/participant/{id}', "TopicController@actionParticipant")->name('topic_ad_participant_page');

        Route::get('/status/{id}', "TopicController@actionStatus")->name('topic_ad_status_data');
        Route::get('/create', "TopicController@actionCreate")->name('topic_ad_create_page');

        Route::get('/delete/{id}', "TopicController@actionDelete")->name('topic_ad_delete_data');

        Route::post('/create', "TopicController@actionCreate")->name('topic_ad_create_data');
        Route::post('/update_data', "TopicController@actionUpdate")->name('topic_ad_update_data');



    });

    Route::group(['prefix' => '/account'], function () {
        Route::get('/', "AccountController@actionIndex")->name('account_ad_index_page');
    });


});