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
    Route::get('/{id}', "HomeController@actionView")->name('home_view_page');
});

Route::group(['prefix' => '/profile', 'middleware' => [ 'guest' ] ], function () {
    Route::post('/update', "ProfileController@actionUpdate")->name('profile_update_data');
    Route::post('/upload', "ProfileController@actionUpload")->name('profile_upload_data');
    Route::get('/submission/{id}', "ProfileController@actionSubmission")->name('profile_submission_data');
    Route::get('/backsteps/{id}', "ProfileController@actionBackSteps")->name('profile_backsteps_data');
    Route::get('/bypass_file/{id}', "ProfileController@actionAttachment")->name('profile_bypassfile_data');
    Route::get('/delete_file/{id}', "FileJourController@actionFileJourDelete")->name('profile_delete_filejour_data');
});



Route::group(['prefix' => '/admin', 'middleware' => [ 'guest' , 'admin' ] ], function () {

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

    Route::group(['prefix' => '/excel'], function () {
        Route::get('/participant/{id}', "TopicController@actionGenerateExcel")->name('excel_ad_participant_data');
    });

    Route::group(['prefix' => '/profile'], function () {
        Route::get('/status/{id}', "ProfileController@actionStatus")->name('profile_ad_status_data');
    });

    Route::group(['prefix' => '/account'], function () {
        Route::get('/', "AccountController@actionIndex")->name('account_ad_index_page');
    });


});