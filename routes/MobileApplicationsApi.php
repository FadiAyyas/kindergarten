<?php

use Illuminate\Support\Facades\Route;



$credentialsAuthParent = [
    'namespace' => 'App\Http\Controllers\Api\MobileApplications',
    'middleware' => ['CheckToken:parent_api'],
];


Route::group($credentialsAuthParent, function () {
    /* Parent application routes start */
    Route::post('/getChildren', 'ParentApplicationController@getChildren');
    Route::post('/getChildInfo/{child_id}', 'ParentApplicationController@getChildInfo');
    Route::post('/getEvaluations/{child_id}', 'ParentApplicationController@getEvaluations');
    Route::post('/getSubjectEvaluations/{child_id}', 'ParentApplicationController@getSubjectEvaluations');
    Route::post('/getTeacher/{child_id}', 'ParentApplicationController@getTeacher');
    Route::post('/getBusSuperVisor/{child_id}', 'ParentApplicationController@getBusSuperVisor');
    Route::post('/getKgContact', 'ParentApplicationController@getKgContact');
    Route::post('/getActivitiesInfo', 'ParentApplicationController@getActivitiesInfo');
    Route::post('/getKgImages', 'ParentApplicationController@getKgImages');
    Route::post('/abcenseRecording', 'ParentApplicationController@abcenseRecording');
    /* parent chat start */
    Route::post('/sendParentMessage', 'ChatController@sendParentMessage');
    Route::post('/getChatsForParent', 'ChatController@getChatsForParent');
    Route::post('/getMessagesForParent/{employee_id}', 'ChatController@getMessagesForParent');
    /* parent chat end */
    /* Parent application routes end */
});


$credentialsAuthEmployee = [
    'namespace' => 'App\Http\Controllers\Api\MobileApplications',
    'middleware' => ['CheckToken:employee_api'],
];
Route::group($credentialsAuthEmployee, function () {
    /* Teacher application routes end */
    Route::post('/getClassChildren', 'TeacherApplicationController@getClassChildren');
    Route::post('/childAbsence', 'TeacherApplicationController@childAbsence');
    Route::post('/setChildEval', 'TeacherApplicationController@setChildEval');
    Route::post('/sendNewEvalNotify', 'TeacherApplicationController@sendNewEvalNotify');
    Route::post('/getSeasonSubjects/{child_id}', 'TeacherApplicationController@getSeasonSubjects');
    Route::post('/setSubjectChildEval/{child_id}', 'TeacherApplicationController@setSubjectChildEval');
    /* Teacher application routes end */

    /* Bus Supervisor application routes end */
    Route::post('/getBusChildren', 'BusSupervisorApplicationController@getBusChildren');
    Route::post('/getBusItinerary', 'BusSupervisorApplicationController@getBusItinerary');
    Route::post('/getParentPhoneNumbers/{child_id}', 'BusSupervisorApplicationController@getParentPhoneNumbers');
    Route::post('/sendBusNotify', 'BusSupervisorApplicationController@sendBusNotify');
    /* Bus Supervisor application routes end */

    /* teacher chat start */
    Route::post('/sendEmployeeMessage', 'ChatController@sendEmployeeMessage');
    Route::post('/getChatsForTeacher', 'ChatController@getChatsForTeacher');
    Route::post('/getMessagesForTeacher/{parent_id}', 'ChatController@getMessagesForTeacher');
    /* teachaer chat end */
});
