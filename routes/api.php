<?php

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

// start auth
Route::post('password/email', 'ApiAuth\ForgotPasswordController@sendResetLinkEmail');
Route::put('password/reset', 'ApiAuth\ResetPasswordController@reset');

Route::group(['prefix' => 'auth', 'namespace' => 'ApiAuth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'auth', 'namespace' => 'ApiAuth'], function () {
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
});
// end auth

Route::group(['middleware' => 'auth:api'], function ()
{
    // user
    Route::patch('profile/update', 'UserController@updateProfile');
    Route::post('password/check', 'UserController@checkPassword');
    Route::patch('password/change', 'UserController@changePassword');
    Route::post('change/image', 'UserController@changeImage');

    Route::get('tasks', 'UserController@getTasks');
    Route::patch('tasks/update-status/{task}', 'UserController@updateTaskStatus');

    Route::group(['middleware' => 'admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function ()
    {
        Route::apiResource('users', 'UserController');

        Route::get('get-users', 'TaskController@getUsers');
        Route::apiResource('tasks', 'TaskController');
    });
});

