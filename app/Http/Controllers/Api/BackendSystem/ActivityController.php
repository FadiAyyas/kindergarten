<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Events\NewActivityListener;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ActivityRequest;
use App\Models\Activity;
use App\Http\Traits\GeneralTrait;
use Throwable;

class ActivityController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {
            $details = Activity::all();
            return $this->returnData('Activities', $details, ' Activity details ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function store(ActivityRequest $request)
    {
        $input = $request->all();
        try {
            $activity = Activity::create($input);
            broadcast(new NewActivityListener($activity));
            return $this->returnSuccessMessage('Activity created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(ActivityRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = Activity::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('Activity update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Activity does not exists');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Activity::findOrFail($id);
            $data->delete();
            return $this->returnError("Activity delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Activity does not exists');
        }
    }
}
