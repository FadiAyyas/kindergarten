<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Models\KGClass;
use App\Models\Level;
use App\Models\Employee;
use App\Http\Traits\GeneralTrait;
use App\Http\Requests\Backend\ClassRequest;
use Throwable;
use Illuminate\Support\Facades\DB;

class ClassController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {

            $classes = Level::Join("Kgclasses", "levels.id", "=", "Kgclasses.level_id")
            ->Join("teacher_classes", "teacher_classes.class_id", "=", "Kgclasses.id")
            ->Join("employees", "employees.id", "=", "teacher_classes.employee_id")
            ->get([
                'Kgclasses.id as class_id','Kgclasses.class_name', 'Kgclasses.maxCapacity',
                'levels.id as level_id','levels.level_name', 'levels.level_minAge', 'levels.level_maxAge',
                'employees.id as emp_id','employees.firstName','employees.lastName' ,
            ])->all();

            return $this->returnData('Classes', $classes, ' Classes details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }
    public function store(ClassRequest $request)
    {
        try {
            $employee = Employee::findOrFail($request->employee_id);
            $level = Level::findOrFail($request->level_id);
            $class = new KGClass();

            $class->class_name = $request->class_name;
            $class->maxCapacity = $request->maxCapacity;

            DB::transaction(function () use ($employee, $level, $class) {
                $level->classes()->save($class);
                $class->teacher()->save($employee);
            });
            return $this->returnSuccessMessage('class created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(ClassRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = KGClass::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('class update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong');
        }
    }

    public function destroy($id)
    {
        try {
            $data = KGClass::findOrFail($id);
            $data->delete();
            return $this->returnError("class delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('class does not exists');
        }
    }
}
