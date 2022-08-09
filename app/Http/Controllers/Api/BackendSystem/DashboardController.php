<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function statistics()
    {
        $classes = DB::table('kgclasses')->count();
        $levels = DB::table('levels')->count();
        $employees = DB::table('employees')->count();
        $activities = DB::table('activities')->count();
        $buses = DB::table('buses')->count();
        $childrens = DB::table('childrens')->count();
    }

}
