<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\KindergartenRequest;
use App\Models\Kindergarten;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\GeneralTrait;
use Throwable;

class KindergartenController extends Controller
{
    use GeneralTrait, ImageUploadTrait;

    public function store(KindergartenRequest $request)
    {
        $input = $request->all();
        try {
            $input['logo'] = $this->uploadImage('logo', $request->logo, 'Kindergarten/images/');
            $input['webHeaderImage'] = $this->uploadImage('webHeaderImage', $request->webHeaderImage, 'Kindergarten/images/');
            Kindergarten::create($input);
            return $this->returnSuccessMessage('Data created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(KindergartenRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = Kindergarten::findOrFail($id);

            if ($request->logo) {
                $this->imageDelete($data->logo);
                $input['logo'] = $this->uploadImage('logo', $request->logo, 'Kindergarten/images/');
            }
            if ($request->webHeaderImage) {
                $this->imageDelete($data->webHeaderImage);
                $input['webHeaderImage'] = $this->uploadImage('webHeaderImage', $request->webHeaderImage, 'Kindergarten/images/');
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
            $data = Kindergarten::findOrFail($id);
            $this->imageDelete($data->logo);
            $this->imageDelete($data->webHeaderImage);
            $data->delete();
            return $this->returnError("Kindergarten details delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Kindergarten details does not exists');
        }
    }
}
