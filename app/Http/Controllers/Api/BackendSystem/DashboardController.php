<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\GeneralTrait;

class DashboardController extends Controller
{
    use GeneralTrait;
    public function statistics()
    {
        try {


            $levels = DB::table('levels')->count();
            $classes = DB::table('kgclasses')->count();
            $employees = DB::table('employees')->count();
            $activities = DB::table('activities')->count();
            $buses = DB::table('buses')->count();
            $childrens = DB::table('childrens')->count();
            $subjects = DB::table('subjects')->count();

            $data = [
            'classes' => $classes,
             'levels' => $levels,
             'employees' => $employees,
             'activities' => $activities,
             'buses' => $buses,
             'childrens' => $childrens,
             'subjects' => $subjects
           ];

            return $this->returnData('details', $data, ' Kindergarten statistics ');
        } catch (Exception $e) {
            return $this->returnError($e);
        }

        //الاعضاء المنضمين حديثا
        //اخر اربع سنوات  + عدد الاطفال +المرابح

    }

}
