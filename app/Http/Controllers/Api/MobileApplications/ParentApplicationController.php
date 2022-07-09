<?php

namespace App\Http\Controllers\Api\MobileApplications;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileApplications\parentChildAbcenceRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Activity;
use App\Models\Children;
use App\Models\ChildSubjectEval;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Models\Gallery;
use App\Models\KgContact;
use App\Models\ParentChildAbsence;
use App\Models\Registration;
use App\Models\Season_year;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ParentApplicationController extends Controller
{
    use GeneralTrait;
    public function getChildren()
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $children = Registration::join("childrens", "childrens.id", "=", "registrations.child_id")
                ->where('registrations.season_year_id', $season_year->id)
                ->where('childrens.parent_id', Auth::user()->id)
                ->get(['childrens.id', 'childrens.childName', 'childrens.ChildImage']);

            return $this->returnData('children', $children, ' children ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getChildInfo($child_id)//add class id
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('season_year_id', $season_year->id)
                ->where('child_id', $child_id)->first();

            $children = Children::join("registrations", "registrations.child_id", "=", "childrens.id")
                ->join("Kgclasses", "Kgclasses.id", "=", "registrations.class_id")
                ->join("levels", "levels.id", "=", "Kgclasses.level_id")
                ->where('registrations.id', $registration->id)
                ->get([
                    'childrens.id as child_id', 'childrens.childName', 'childrens.ChildImage',
                    'Kgclasses.id as class_id','Kgclasses.class_name', 'levels.level_name'
                ]);
            return $this->returnData('childInfo', $children, ' children info');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getEvaluations($child_id)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('season_year_id', $season_year->id)
                ->where('child_id', $child_id)->first();
            $eval = Evaluation::where('registration_id', $registration->id)->get(['behavioral', 'social']);
            return $this->returnData('evaluations', $eval, ' evaluations ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getSubjectEvaluations($child_id)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('season_year_id', $season_year->id)
                ->where('child_id', $child_id)->first();
            $subjectsEval = ChildSubjectEval::join("subjects", "subjects.id", "=", "child_subject_evals.subject_id")
                ->where('child_subject_evals.registration_id', $registration->id)
                ->get(['subjects.subject_name', 'child_subject_evals.evaluation']);

            return $this->returnData('subjectsEval', $subjectsEval, ' subjects evaluation ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function getTeacher($child_id) //add employee id
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('registrations.season_year_id', $season_year->id)
                ->where('child_id', $child_id)->first();
            $teacher = Employee::join("teacher_classes", "teacher_classes.employee_id", "=", "employees.id")
                ->join("Kgclasses", "Kgclasses.id", "=", "teacher_classes.class_id")
                ->join("registrations", "registrations.class_id", "=", "Kgclasses.id")
                ->where('registrations.id', $registration->id)
                ->first([
                    'employees.id','employees.firstName', 'employees.lastName'
                    , 'employees.photo','employees.phoneNumber'
                ]);

            return $this->returnData('techer', $teacher, ' teacher');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getBusSuperVisor($child_id)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('registrations.season_year_id', $season_year->id)
                ->where('child_id', $child_id)->first();
            $busSupervisor = Employee::join("buses", "buses.employee_id", "=", "employees.id")
                ->join("bus_children", "bus_children.bus_id", "=", "buses.id")
                ->join("registrations", "registrations.id", "=", "bus_children.registration_id")
                ->where('registrations.id', $registration->id)
                ->first([
                    'employees.firstName', 'employees.lastName', 'employees.photo',
                    'employees.phoneNumber', 'buses.busTypeName', 'buses.plateNumber'
                ]);

            return $this->returnData('busSupervisor', $busSupervisor, ' bus supervisor ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function getKgContact()
    {
        try {
            $contacts = KgContact::all();
            return $this->returnData('KgContact', $contacts, ' Kindergaten Contacts info ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getActivitiesInfo()
    {
        try {
            $details = Activity::all();
            return $this->returnData('Activities', $details, ' Activity details ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getKgImages()
    {
        try {
            $images = Gallery::all();
            return $this->returnData('images', $images, ' Kg images ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function abcenseRecording(parentChildAbcenceRequest $request)
    {
        $season_year = Season_year::latest('id')->first();
        $registration = Registration::where('registrations.season_year_id', $season_year->id)
            ->where('child_id', $request->child_id)->first();
        try {
            ParentChildAbsence::create([
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'reason' => $request->reason,
                'registration_id' => $registration->id,
            ]);
            return $this->returnSuccessMessage('تم تسجيل طلب غياب بنجاح');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
}
