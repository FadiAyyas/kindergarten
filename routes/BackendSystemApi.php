<?php

use Illuminate\Support\Facades\Route;

$backendSystem = [
    'namespace' => 'App\Http\Controllers\Api\BackendSystem',
    'middleware' => ['cors']
];




Route::group($backendSystem, function () {

    //Kindergarten Route
    Route::post('/storeKindergartenDetails', 'KindergartenController@store');
    Route::post('/updateKindergartenDetails/{id}', 'KindergartenController@update');
    Route::post('/deleteKindergartenDetails/{id}', 'KindergartenController@destroy');

    Route::post('/uploadGalleryImage', 'GallaryController@store');
    Route::post('/deleteGalleryImage/{id}', 'GallaryController@destroy');

    //Services Route
    Route::post('/storeService', 'ServiceController@store');
    Route::post('/updateService/{id}', 'ServiceController@update');
    Route::post('/deleteService/{id}', 'ServiceController@destroy');


    //Activities Route
    Route::post('/showActivities', 'ActivityController@index');
    Route::post('/storeActivity', 'ActivityController@store');
    Route::post('/updateActivity/{id}', 'ActivityController@update');
    Route::post('/deleteActivity/{id}', 'ActivityController@destroy');

    Route::post('/uploadActivityImage', 'ActivityImagesController@store');
    Route::post('/deleteActivityImage/{id}', 'ActivityImagesController@destroy');

    //Contact Route
    Route::post('/storeContact', 'ContactController@store');
    Route::post('/updateContact/{id}', 'ContactController@update');
    Route::post('/deleteContact/{id}', 'ContactController@destroy');

    //Employees Route
    Route::post('/showEmployeesDetails', 'EmployeesController@index');
    Route::post('/storeEmployeeDetails', 'EmployeesController@store');
    Route::post('/updateEmployeeDetails/{id}', 'EmployeesController@update');
    Route::post('/deleteEmployeeDetails/{id}', 'EmployeesController@destroy');

    Route::post('/available-Teachers', 'EmployeesController@availableTeachers');
    Route::post('/available-Bus-Supervisors', 'EmployeesController@availableBusSupervisors');

    Route::post('/assigningEmployeeClass/{class_id}', 'EmployeesController@assigningEmployeeClass');


    //Levels Route
    Route::post('/showLevelsDetails', 'LevelsController@index');
    Route::post('/storeLevelDetails', 'LevelsController@store');
    Route::post('/updateLevelDetails/{id}', 'LevelsController@update');
    Route::post('/deleteLevelDetails/{id}', 'LevelsController@destroy');

    //Classes Route
    Route::post('/showClassesDetails', 'ClassController@index');
    Route::post('/storeClassDetails', 'ClassController@store');
    Route::post('/updateClassDetails/{id}', 'ClassController@update');
    Route::post('/deleteClassDetails/{id}', 'ClassController@destroy');

    //Season Route
    Route::post('/showSeason', 'SeasonYearController@showSeason');
    Route::post('/showSeasonYearDetails', 'SeasonYearController@index');
    Route::post('/storeSeasonYearDetails', 'SeasonYearController@store');
    Route::post('/updateSeasonYearDetails/{id}', 'SeasonYearController@update');
    Route::post('/deleteSeasonYearDetails/{id}', 'SeasonYearController@destroy');

    //Parents Route
    Route::post('/showParentsDetails', 'ParentController@index');
    Route::post('/storeParentsDetails', 'ParentController@store');
    Route::post('/updateParentsDetails/{parent_id}', 'ParentController@updateParentDetails');
    Route::post('/updateParentContactsDetails/{phone_id}', 'ParentController@updateParentContactsDetails');
    Route::post('/deleteParentsDetails/{parent_id}', 'ParentController@destroy');

    //Childrens Route
    Route::post('/showChildrensDetails', 'ChildrensController@index');
    Route::post('/storeChildrensDetails/{parent_id}', 'ChildrensController@store');
    Route::put('/updateChildrensDetails/{child_id}', 'ChildrensController@update');
    Route::post('/deleteChildDetails/{child_id}', 'ChildrensController@destroy');

    Route::post('/showFathersChildrensDetails/{parent_id}', 'ChildrensController@ShowFathersChildrensDetails');
    Route::post('/showChildDetails/{child_id}', 'ChildrensController@showChildDetails');

    Route::post('/showChildAbsence/{child_id}', 'ChildrensController@showChildAbsence');
    Route::post('/showChildEvaluations/{child_id}', 'ChildrensController@showChildEvaluations');
    //Route::post('/searchChildrensDetails','ChildrensController@searchChild');

    //Buses Route
    Route::post('/showBusItineraries', 'BusesController@showBusItineraries');
    Route::post('/showBuses/{Itinerary_id}', 'BusesController@showBuses');
    Route::post('/storeItinerary', 'BusesController@storeItinerary');
    Route::post('/updateItinerary/{Itinerary_id}', 'BusesController@updateItinerary');

    Route::post('/storeBuses/{Itinerary_id}', 'BusesController@storeBuses');
    Route::post('/updateBuses/{Bus_id}', 'BusesController@updateBuses');

    Route::post('/registeringChildOnBus/{Bus_id}', 'BusesController@registeringChildOnBus');

    Route::post('/deleteItinerary/{Itinerary_id}', 'BusesController@deleteItinerary');
    Route::post('/deleteBus/{Bus_id}', 'BusesController@deleteBus');

    //subjects Route
    Route::post('/showSubject', 'SubjectsController@index');
    Route::post('/storeSubject', 'SubjectsController@store');
    Route::post('/updateSubject/{id}', 'SubjectsController@update');
    Route::post('/deleteSubject/{id}', 'SubjectsController@destroy');
});

