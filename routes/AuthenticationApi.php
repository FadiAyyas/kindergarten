<?php

use Illuminate\Support\Facades\Route;

$credentialsAuthParent = [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['CheckToken:parent_api'],
];

Route::group(['middleware' => ['auth.guard:parent_api'], 'namespace' => 'App\Http\Controllers\Api',], function () {

    Route::post('/parent-login', 'ParentAuthController@login');
});

Route::group($credentialsAuthParent, function () {

    Route::post('/parent-changePassword', 'ParentAuthController@changePassword');
    Route::post('/parent-logout', 'ParentAuthController@logout');
    Route::post('/parent-refresh', 'ParentAuthController@refresh');
    Route::post('/parent-user-profile', 'ParentAuthController@userProfile');
});



$credentialsAuthEmployee = [
    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => ['CheckToken:employee_api'],
];

Route::group(['middleware' => ['auth.guard:employee_api'], 'namespace' => 'App\Http\Controllers\Api',], function () {

    Route::post('/employee-login', 'EmployeeAuthController@login');
});

Route::group($credentialsAuthEmployee, function () {

    Route::post('/employee-changePassword', 'EmployeeAuthController@changePassword');
    Route::post('/employee-logout', 'EmployeeAuthController@logout');
    Route::post('/employee-refresh', 'EmployeeAuthController@refresh');
    Route::post('/employee-user-profile', 'EmployeeAuthController@userProfile');
});
