<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', 'HomeController@index')->name('welcome');
Auth::routes();
Route::get('/logout', 'LogoutController@redirect');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth','admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // User Requests
    Route::delete('user-requests/destroy', 'UserRequestsController@massDestroy')->name('user-requests.massDestroy');
    Route::post('user-requests/media', 'UserRequestsController@storeMedia')->name('user-requests.storeMedia');
    Route::post('user-requests/ckmedia', 'UserRequestsController@storeCKEditorImages')->name('user-requests.storeCKEditorImages');
    Route::resource('user-requests', 'UserRequestsController');

    // Users
    Route::patch('users/tocompany', 'UsersController@toCompany')->name('users.tocompany');
    Route::patch('users/touser', 'UsersController@toUser')->name('users.touser');
    Route::patch('users/approve', 'UsersController@approve')->name('users.approve');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Service Stations
    Route::patch('service-stations/approve', 'ServiceStationsController@approve')->name('service-stations.approve');
    Route::delete('service-stations/destroy', 'ServiceStationsController@massDestroy')->name('service-stations.massDestroy');
    Route::post('service-stations/media', 'ServiceStationsController@storeMedia')->name('service-stations.storeMedia');
    Route::post('service-stations/ckmedia', 'ServiceStationsController@storeCKEditorImages')->name('service-stations.storeCKEditorImages');
    Route::resource('service-stations', 'ServiceStationsController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Cars
    Route::delete('cars/destroy', 'CarsController@massDestroy')->name('cars.massDestroy');
    Route::resource('cars', 'CarsController');

    // Repairs
    Route::delete('repairs/destroy', 'RepairsController@massDestroy')->name('repairs.massDestroy');
    Route::post('repairs/media', 'RepairsController@storeMedia')->name('repairs.storeMedia');
    Route::post('repairs/ckmedia', 'RepairsController@storeCKEditorImages')->name('repairs.storeCKEditorImages');
    Route::resource('repairs', 'RepairsController');

    // Parts
    Route::delete('parts/destroy', 'PartsController@massDestroy')->name('parts.massDestroy');
    Route::resource('parts', 'PartsController');

    // Tasks
    Route::delete('tasks/destroy', 'TasksController@massDestroy')->name('tasks.massDestroy');
    Route::resource('tasks', 'TasksController');

    // Upcomings
    Route::delete('upcomings/destroy', 'UpcomingsController@massDestroy')->name('upcomings.massDestroy');
    Route::post('upcomings/media', 'UpcomingsController@storeMedia')->name('upcomings.storeMedia');
    Route::post('upcomings/ckmedia', 'UpcomingsController@storeCKEditorImages')->name('upcomings.storeCKEditorImages');
    Route::resource('upcomings', 'UpcomingsController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::patch('user-alerts/read', 'UserAlertsController@edit')->name('user-alerts.read');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['prefix' => 'app','as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // User Requests
    Route::delete('user-requests/destroy', 'UserRequestsController@massDestroy')->name('user-requests.massDestroy');
    Route::post('user-requests/media', 'UserRequestsController@storeMedia')->name('user-requests.storeMedia');
    Route::post('user-requests/ckmedia', 'UserRequestsController@storeCKEditorImages')->name('user-requests.storeCKEditorImages');
    Route::resource('user-requests', 'UserRequestsController');

    // Users
    Route::patch('users/touser', 'UsersController@toUser')->name('users.touser');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Service Stations
    Route::patch('service-stations/approve', 'ServiceStationsController@approve')->name('service-stations.approve');
    Route::patch('service-stations/cancel', 'ServiceStationsController@cancel')->name('service-stations.cancel');
    Route::delete('service-stations/destroy', 'ServiceStationsController@massDestroy')->name('service-stations.massDestroy');
    Route::post('service-stations/media', 'ServiceStationsController@storeMedia')->name('service-stations.storeMedia');
    Route::post('service-stations/ckmedia', 'ServiceStationsController@storeCKEditorImages')->name('service-stations.storeCKEditorImages');
    Route::resource('service-stations', 'ServiceStationsController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Cars
    Route::delete('cars/destroy', 'CarsController@massDestroy')->name('cars.massDestroy');
    Route::resource('cars', 'CarsController');

    // Repairs
    Route::patch('repairs/approve', 'RepairsController@approve')->name('repairs.approve');
    Route::post('repairs/fin', 'RepairsController@fin')->name('repairs.fin');
    Route::patch('repairs/suspend', 'RepairsController@suspend')->name('repairs.suspend');
    Route::patch('repairs/task', 'RepairsController@task')->name('repairs.task');
    Route::patch('repairs/cancel', 'RepairsController@cancel')->name('repairs.cancel');
    Route::delete('repairs/destroy', 'RepairsController@massDestroy')->name('repairs.massDestroy');
    Route::post('repairs/media', 'RepairsController@storeMedia')->name('repairs.storeMedia');
    Route::post('repairs/ckmedia', 'RepairsController@storeCKEditorImages')->name('repairs.storeCKEditorImages');
    Route::resource('repairs', 'RepairsController');

    // Parts
    Route::delete('parts/destroy', 'PartsController@massDestroy')->name('parts.massDestroy');
    Route::resource('parts', 'PartsController');

    // Tasks
    Route::delete('tasks/destroy', 'TasksController@massDestroy')->name('tasks.massDestroy');
    Route::resource('tasks', 'TasksController');

    // Upcomings
    Route::delete('upcomings/destroy', 'UpcomingsController@massDestroy')->name('upcomings.massDestroy');
    Route::post('upcomings/media', 'UpcomingsController@storeMedia')->name('upcomings.storeMedia');
    Route::post('upcomings/ckmedia', 'UpcomingsController@storeCKEditorImages')->name('upcomings.storeCKEditorImages');
    Route::resource('upcomings', 'UpcomingsController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
    Route::patch('user-alerts/read', 'UserAlertsController@edit')->name('user-alerts.read');

    Route::patch('profile/approve', 'ProfileController@approve')->name('profile.approve');
    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::post('profile', 'ProfileController@update')->name('profile.update');
    Route::post('profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('profile/password', 'ProfileController@password')->name('profile.password');
});
