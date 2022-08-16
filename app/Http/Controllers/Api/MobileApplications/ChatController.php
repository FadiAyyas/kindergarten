<?php

namespace App\Http\Controllers\Api\MobileApplications;

use App\Events\EmployeeChatListener;
use App\Events\ParentChatListener;
use App\Http\Controllers\Controller;
use App\Http\Requests\MobileApplications\sendEmployeeMessageRequest;
use App\Http\Requests\MobileApplications\sendParentMessageRequest;
use App\Http\Traits\GeneralTrait;
use App\Models\Chat;
use App\Models\Employee;
use App\Models\ParentCh;
use App\Models\Registration;
use App\Models\Season_year;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Throwable;

class ChatController extends Controller
{
    use GeneralTrait;

    // parent methods start
    public function sendParentMessage(sendParentMessageRequest $request)
    {

        try {
            Chat::create([
                'message' => Crypt::encryptString($request->message),
                'parent_id' => Auth::user()->id,
                'employee_id' => $request->employee_id,
                'from' => 'parent',
                'to' => 'employee'
            ]);
            $parent = ParentCh::where('id', Auth::user()->id)->first();

            broadcast(new EmployeeChatListener($request->message, $request->employee_id, $parent));

            return $this->returnSuccessMessage('Message send successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function getChatsForParent()
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $chats = Registration::join("childrens", "childrens.id", "=", "registrations.child_id")
                ->join("teacher_classes", "teacher_classes.class_id", "=", "registrations.class_id")
                ->join("employees", "employees.id", "=", "teacher_classes.employee_id")
                ->where('registrations.season_year_id', $season_year->id)
                ->where('childrens.parent_id', Auth::user()->id)
                ->get([
                    'childrens.id as child_id', 'childrens.childName',
                    'employees.id as employee_id', 'employees.firstName',
                    'employees.lastName', 'employees.photo'
                ]);

            return $this->returnData('chats', $chats, 'chats');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getMessagesForParent($employee_id)
    {
        try {
            $messages = Chat::where('parent_id', Auth::user()->id)
                ->where('employee_id', $employee_id)->get();

            foreach ($messages as $message) {
                $message->isRead = 1;
                $message->save();
                $message->message = Crypt::decryptString($message->message);
            }
            return $this->returnData('messages', $messages, 'messages');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    // parent methods end

    // techaer methods start
    public function sendEmployeeMessage(sendEmployeeMessageRequest $request)
    {
        try {
            Chat::create([
                'message' => Crypt::encryptString($request->message),
                'parent_id' => $request->parent_id,
                'employee_id' => Auth::user()->id,
                'from' => 'employee',
                'to' => 'parent',
            ]);
            $employee = Employee::where('id', Auth::user()->id)->first();

            broadcast(new ParentChatListener($request->message, $request->parent_id, $employee));

            return $this->returnSuccessMessage('Message send successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }
    public function sendGroupEmployeeMessage(Request $request)
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $class_id=TeacherClass::where("employee_id",Auth::user()->id)->first();
            $parents=Registration::join("childrens","childrens.id","=","child_id")
                     ->join("parents","parents.id","=","childrens.parent_id")
                     ->where('registrations.season_year_id',$season_year->id)
                     ->where("registrations.class_id",$class_id->class_id)
                     ->distinct()
                     ->pluck('parents.id')->toArray();

                     foreach($parents as $id){
                        Chat::create([
                            'message' => Crypt::encryptString($request->message),
                            'parent_id' => $id,
                            'employee_id' => Auth::user()->id,
                            'from' => 'employee',
                            'to' => 'parent',
                        ]);
                        $employee = Employee::where('id', Auth::user()->id)->first();

                        broadcast(new ParentChatListener($request->message, $id, $employee));
                     }
            return $this->returnSuccessMessage('Message send successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }
    public function getChatsForTeacher()
    {
        try {
            $season_year = Season_year::latest('id')->first();
            $class_id = Employee::join("teacher_classes", "teacher_classes.employee_id", "=", "employees.id")
                ->join("Kgclasses", "Kgclasses.id", "=", "teacher_classes.class_id")
                ->where('employees.id', Auth::user()->id)
                ->get('Kgclasses.id')->first();

            $chats = Registration::join("childrens", "childrens.id", "=", "registrations.child_id")
                ->join("parents", "parents.id", "=", "childrens.parent_id")
                ->where('registrations.class_id', $class_id->id)
                ->where('registrations.season_year_id', $season_year->id)
                ->get([
                    'childrens.id as child_id', 'childrens.childName',
                    'childrens.ChildImage', 'parents.id as parent_id',
                    'parents.fatherName', 'parents.motherName'
                ]);

            return $this->returnData('chats', $chats, 'chats');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }

    public function getMessagesForTeacher($parent_id)
    {
        try {
            $messages = Chat::where('parent_id', $parent_id)
                ->where('employee_id', Auth::user()->id)->get();
            foreach ($messages as $message) {
                $message->isRead = 1;
                $message->save();
                $message->message = Crypt::decryptString($message->message);
            }
            return $this->returnData('messages', $messages, 'messages');
        } catch (Throwable $e) {
            return $this->returnError('هناك مشكلة ما , يرجى المحاولة مرة اخرى في وقت لاحق');
        }
    }
    // techaer methods end
}
