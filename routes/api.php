<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Service Stations
    Route::post('service-stations/media', 'ServiceStationsApiController@storeMedia')->name('service-stations.storeMedia');
    Route::apiResource('service-stations', 'ServiceStationsApiController');

    // Cars
    Route::apiResource('cars', 'CarsApiController');

    // Repairs
    Route::post('repairs/media', 'RepairsApiController@storeMedia')->name('repairs.storeMedia');
    Route::apiResource('repairs', 'RepairsApiController');

    // Parts
    Route::apiResource('parts', 'PartsApiController');

    // Tasks
    Route::apiResource('tasks', 'TasksApiController');

    // Upcomings
    Route::post('upcomings/media', 'UpcomingsApiController@storeMedia')->name('upcomings.storeMedia');
    Route::apiResource('upcomings', 'UpcomingsApiController');
});
