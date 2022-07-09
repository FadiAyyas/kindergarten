<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*    Testing Api    */

$webSite = [
    'namespace' => 'App\Http\Controllers\Api\Website',
];

Route::group($webSite, function () {
    Route::post('/getCurrentLevelsCost','WebsiteController@getCurrentLevelsCost');
    Route::post('/getKindergartenDetails','WebsiteController@getKindergartenDetails');
    Route::post('/getGalleryImages','WebsiteController@getGalleryImages');
    Route::post('/getServicesDetails','WebsiteController@getServicesDetails');
    Route::post('/getContactDetails','WebsiteController@getContactDetails');
    Route::post('/getActivityImages','WebsiteController@getActivityImages');
});



