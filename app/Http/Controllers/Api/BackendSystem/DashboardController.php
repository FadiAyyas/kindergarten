<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use GeneralTrait;
    public function statistics()
    {
        try {


            $levels = DB::table('levels')->count();
            $classes = DB::table('Kgclasses')->count();
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


    }
    public function dataChart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|numeric|min:2021|max:2050'
        ]);

        if ($validator->fails()) {
            return $this->returnError($validator->errors());
        }

        $sesons_year = array();
        $price=array();
        $countChild=array();

    }

}
