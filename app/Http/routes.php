<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group([ 'middleware' => 'guest' ], function () {
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');

    // Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    // Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');
});

Route::group([ 'middleware' => 'auth' ], function () {
    Route::get('/', [
        'as' => 'home',
        'uses' => 'ProjectController@index'
    ]);
    Route::get('/project/create', [
        'as' => 'project.create',
        'uses' => 'ProjectController@create'
    ]);
    Route::post('/project/create', [
        'as' => 'project.store',
        'uses' => 'ProjectController@store'
    ]);
    Route::post('/project/search', [
        'as' => 'project.search',
        'uses' => 'ProjectController@search'
    ]);
    Route::get('/project/{project}/graph', [
        'as' => 'detail.graph',
        'uses' => 'ProjectDetailController@graph'
    ]);
    Route::get('/project/{project}/overview', [
        'as' => 'detail.overview',
        'uses' => 'ProjectDetailController@overview'
    ]);
    Route::get('/project/{project}/activity', [
        'as' => 'detail.activity',
        'uses' => 'ProjectDetailController@activity'
    ]);
    Route::get('/project/{project}/inspection-{issue}/{category}', [
        'as' => 'detail.issue',
        'uses' => 'ProjectDetailController@issue'
    ]);
    Route::post('/project/{project}/inspection-{issue}/', [
        'as' => 'detail.issue.category',
        'uses' => 'ProjectDetailController@issueByCategory'
    ]);
    Route::delete('/project/{project}', [
        'as' => 'project.destroy',
        'uses' => 'ProjectController@destroy'
    ]);
    Route::get('/project/{project}/inspect', [
        'as' => 'inspection.create',
        'uses' => 'ProjectDetailController@create'
    ]);
    Route::post('/project/{project}/inspect', [
        'as' => 'inspection.store',
        'uses' => 'ProjectDetailController@store'
    ]);
    Route::get('logout', 'Auth\AuthController@getLogout');
    Route::group([ 'middleware' => 'role' ], function () {
        Route::resource('user', 'UserController');
    });
});
