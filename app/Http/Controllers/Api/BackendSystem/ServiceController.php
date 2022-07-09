<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ServiceRequest;
use App\Models\Services;
use App\Http\Traits\GeneralTrait;
use Throwable;

class ServiceController extends Controller
{
    use GeneralTrait;
    public function store(ServiceRequest $request)
    {
        $input = $request->all();
        try {
            Services::create($input);
            return $this->returnSuccessMessage('Service created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(ServiceRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = Services::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('Service update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Service does not exists');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Services::findOrFail($id);
            $data->delete();
            return $this->returnError("Service delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Service does not exists');
        }
    }
}
