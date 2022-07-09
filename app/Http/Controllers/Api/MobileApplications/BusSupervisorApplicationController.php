<?php

namespace App\Http\Controllers\Api\MobileApplications;

use App\Events\SendBusNotify;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\BusChild;
use App\Models\Children;
use App\Models\Employee;
use App\Models\ParentPhoneNumbers;
use App\Models\Season_year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BusSupervisorApplicationController extends Controller
{
    use GeneralTrait;
    public function getBusChildren()
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $bus_id = Employee::join("buses", "buses.employee_id", "=", "employees.id")
                ->where('employees.id', Auth::user()->id)
                ->latest('buses.id')->first('buses.id');

            $children = BusChild::join("registrations", "registrations.id", "=", "bus_children.registration_id")
                ->join("childrens", "childrens.id", "=", "registrations.child_id")
                ->where('bus_children.bus_id', $bus_id->id)
                ->where('registrations.season_year_id', $season_year->id)
                ->get([
                    'childrens.id', 'childrens.childName', 'childrens.ChildImage', 'childrens.childAddress'
                ]);

            return $this->returnData('children', $children, 'bus children ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function getParentPhoneNumbers($child_id)
    {
        try {
            $parent = Children::where('id', $child_id)->first('parent_id');
            $parentContact = ParentPhoneNumbers::where('parent_id', $parent->parent_id)
                ->get(['type', 'phoneNumber']);

            return $this->returnData('parentContact', $parentContact, 'parent contact ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getBusItinerary()
    {
        try {
            $itinerary = Employee::join("buses", "buses.employee_id", "=", "employees.id")
                ->join("bus_itineraries", "bus_itineraries.id", "=", "buses.busItinerary_id")
                ->where('employees.id', Auth::user()->id)
                ->latest('buses.id')->first('bus_itineraries.itinerary');

            return $this->returnData('itinerary', $itinerary->itinerary, 'bus itinerary ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function sendBusNotify(Request $request)
    {
        try {
            $bus_id = Employee::join("buses", "buses.employee_id", "=", "employees.id")
                ->where('employees.id', Auth::user()->id)
                ->latest('buses.id')->first('buses.id');
            if ($request->message == null) {
                return $this->returnError('The (message) field is required');
            }

            broadcast(new SendBusNotify($request->message, $bus_id->id));

            return $this->returnSuccessMessage('تم إرسال الإشعار بنجاح');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
}
