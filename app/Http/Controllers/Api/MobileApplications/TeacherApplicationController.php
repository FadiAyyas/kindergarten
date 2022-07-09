<?php

namespace App\Http\Controllers\Api\MobileApplications;

use App\Events\NewEvalNotify;
use App\Http\Controllers\Controller;
use App\Http\Requests\MobileApplications\childEvalRequest;
use App\Http\Requests\MobileApplications\childSubjectEvalRequest;
use App\Http\Requests\MobileApplications\getClassChildrenRequest;
use App\Http\Requests\MobileApplications\teacherChildAbsenceRequest;
use App\Models\Employee;
use App\Models\Registration;
use App\Http\Traits\GeneralTrait;
use App\Models\ChildAbsence;
use App\Models\ChildSubjectEval;
use App\Models\Evaluation;
use App\Models\Season_year;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TeacherApplicationController extends Controller
{
    use GeneralTrait;
    public function getClassChildren(getClassChildrenRequest $request)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $class_id = Employee::join("teacher_classes", "teacher_classes.employee_id", "=", "employees.id")
                ->join("Kgclasses", "Kgclasses.id", "=", "teacher_classes.class_id")
                ->where('employees.id', Auth::user()->id)
                ->get('Kgclasses.id')->first();
            $children = Registration::join("childrens", "childrens.id", "=", "registrations.child_id")
                ->where('registrations.class_id', $class_id->id)
                ->where('registrations.season_year_id', $season_year->id)
                ->get([
                    'childrens.id', 'childrens.childName',
                    'childrens.ChildImage'
                ]);

            foreach ($children as $ch) {
                $reg_id = Registration::where('child_id', $ch['id'])
                    ->where('season_year_id', $season_year->id)
                    ->first('id');
                $abs = ChildAbsence::where('registration_id', $reg_id->id)
                    ->where('date', $request->date)->first();
                $eval = Evaluation::where('registration_id', $reg_id->id)->get(['behavioral', 'social']);
                $subjectEval = ChildSubjectEval::join('subjects', 'subjects.id', '=', 'child_subject_evals.subject_id')
                    ->where('child_subject_evals.registration_id', $reg_id->id)
                    ->get(['subjects.subject_name', 'child_subject_evals.evaluation']);
                if ($abs == null) {
                    Arr::add($ch, 'absence', 0);
                } else {
                    Arr::add($ch, 'absence', 1);
                }
                if (sizeof($eval) != 0) {
                    Arr::add($ch, 'eval', $eval);
                } else {
                    Arr::add($ch, 'eval', 0);
                }
                if (sizeof($subjectEval) != 0) {
                    Arr::add($ch, 'subjectEval', $subjectEval);
                } else {
                    Arr::add($ch, 'subjectEval', 0);
                }
            }

            return $this->returnData('children', $children, ' children ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function childAbsence(teacherChildAbsenceRequest $request)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('child_id', $request->child_id)
                ->where('season_year_id', $season_year->id)
                ->first();

            $absence = ChildAbsence::where('registration_id', $registration->id)
                ->where('date', $request->date)
                ->first();

            if ($absence == null && $request->exist == false) {
                childAbsence::create([
                    'registration_id' => $registration->id,
                    'date' => $request->date
                ]);
                return $this->returnSuccessMessage('تم تسجيل غياب بنجاح');
            }
            if ($absence != null && $request->exist == true) {
                $absence->delete();
                return $this->returnSuccessMessage('تم الغاء تسجيل الغياب بنجاح');
            }
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function setChildEval(childEvalRequest $request)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('registrations.season_year_id', $season_year->id)
                ->where('child_id', $request->child_id)->first();

            $eval = Evaluation::where('registration_id', $registration->id)->first();
            if ($eval == null) {
                Evaluation::create([
                    'behavioral' => $request->behavioral,
                    'social' => $request->social,
                    'registration_id' => $registration->id,
                ]);
                return $this->returnSuccessMessage('تم تسجيل التقييمات بنجاح');
            } else {
                $eval->behavioral = $request->behavioral;
                $eval->social = $request->social;
                $eval->save();
                return $this->returnSuccessMessage('تم تعديل التقييمات بنجاح');
            }
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getSeasonSubjects($child_id)
    {
        try {
            $season_year = Season_year::latest('id')->first();

            $level = Registration::join("Kgclasses", "Kgclasses.id", "=", "registrations.class_id")
                ->where('registrations.season_year_id', $season_year->id)
                ->where('registrations.child_id', $child_id)
                ->first('Kgclasses.level_id');

            $subjects = Subjects::where('level_id', $level->level_id)
                ->where('season_year_id', $season_year->id)
                ->get(['id', 'subject_name']);

            return $this->returnData('subjects', $subjects, ' subjects ');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function setSubjectChildEval(childSubjectEvalRequest $request, $child_id)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $registration = Registration::where('registrations.season_year_id', $season_year->id)
                ->where('child_id', $child_id)->first();

            $eval = ChildSubjectEval::where('registration_id', $registration->id)->get();

            if (sizeof($eval) == 0) {
                foreach ($request->eval as $eval) {
                    ChildSubjectEval::create([
                        'subject_id' => $eval['subject_id'],
                        'evaluation' => $eval['evaluation'],
                        'registration_id' => $registration->id,
                    ]);
                }
                return $this->returnSuccessMessage('تم تسجيل التقييمات بنجاح');
            } else {
                for ($i = 0; $i < sizeof($eval); $i++) {
                    $eval[$i]->subject_id = $request->eval[$i]['subject_id'];
                    $eval[$i]->evaluation = $request->eval[$i]['evaluation'];
                    $eval[$i]->save();
                }
                return $this->returnSuccessMessage('تم تعديل التقييمات بنجاح');
            }
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    public function sendNewEvalNotify(Request $request)
    {
        try {
            $class_id = Employee::join("teacher_classes", "teacher_classes.employee_id", "=", "employees.id")
                ->join("Kgclasses", "Kgclasses.id", "=", "teacher_classes.class_id")
                ->where('employees.id', Auth::user()->id)
                ->get('Kgclasses.id')->first();

            if ($request->message == null) {
                return $this->returnError('The (message) field is required');
            }

            broadcast(new NewEvalNotify($request->message, $class_id->id));

            return $this->returnSuccessMessage('تم إرسال الإشعار بنجاح');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
}
