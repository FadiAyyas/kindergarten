<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\EmployeeRequest;
use App\Models\Employee;
use App\Models\KGClass;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    use GeneralTrait, ImageUploadTrait;

    public function index()
    {
        try {
            $details = Employee::all();
            return $this->returnData('details', $details, ' Employees details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again ');
        }
    }

    public function store(EmployeeRequest $request)
    {
        $input = $request->all();
        try {
            $input['photo'] = $this->uploadImage($input['firstName'], $request->photo, 'Employee/images/');
            $input['password'] = Hash::make($request->password);
            Employee::create($input);
            return $this->returnSuccessMessage('Data created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again ');
        }
    }

    public function update(EmployeeRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = Employee::findOrFail($id);
            if ($request->photo) {
                $this->imageDelete($data->photo);
                $input['photo'] = $this->uploadImage($input['firstName'], $request->photo, 'Employee/images/');
            }
            $data->update($input);
            return $this->returnSuccessMessage('Data update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Image does not exists');
        }
    }

    public function destroy($id)
    {
        try {
            $emp=Employee::findOrFail(Auth::user()->id);
            $data = Employee::findOrFail($id);
            if ($emp->role != 'مدير' && $data->role =='مدير') {
                return $this->returnError("Unauthorize delete Super Admin details ");
            } else {
                $this->imageDelete($data->photo);
                $data->delete();
            }
            return $this->returnSuccessMessage("Employee details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Employee details does not exists');
        }
    }

    public function assigningEmployeeClass(Request $request, $class_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => ['required', 'numeric'],
            ]);
            if ($validator->fails()) {
                return $this->returnError($validator->errors());
            }

            $class = KGClass::findOrFail($class_id);
            $employee = Employee::findOrFail($request->employee_id);
            $class->teacher()->attach($employee);
            return $this->returnSuccessMessage("An employee has been assigned to a class successfully");
        } catch (Throwable $e) {
            return $this->returnError($e);
        }
    }


    public function availableTeachers()
    {
        try {

            $details = Employee::leftJoin('teacher_classes', function($join) {
                $join->on('employees.id', '=', 'teacher_classes.employee_id');
              })
              ->whereNull('teacher_classes.employee_id')
              ->where('employees.role','=','معلم')
              ->get([
                  'employees.id',
                  'employees.firstName',
              ]);

            return $this->returnData('details', $details, 'Available teachers details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again ');
        }
    }



    public function availableBusSupervisors()
    {
        try {
            $details = Employee::leftJoin('buses', function($join) {
                $join->on('employees.id', '=', 'buses.employee_id');
              })
              ->whereNull('buses.employee_id')
              ->where('employees.role','=','مشرف باص')
              ->get([
                  'employees.id',
                  'employees.firstName',
              ]);

            return $this->returnData('details', $details, 'Available Bus supervisors details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again ');
        }
    }
}
