<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use App\Http\Traits\ImageUploadTrait;
use App\Http\Traits\GeneralTrait;
use App\Models\ActivityPhotos;
use App\Http\Requests\Backend\ImagesRequest;
use Throwable;

class ActivityImagesController extends Controller
{
    use GeneralTrait, ImageUploadTrait;

    public function store(ImagesRequest $request)
    {
        try {
            $input = $request->all();
            $input['image_path'] = $this->uploadImage('ActivityImages',  $input['image_path'], 'Kindergarten/ActivityImages/');
            ActivityPhotos::create($input);
            return $this->returnSuccessMessage('Image upload successfully.');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function destroy($id)
    {
        try {
            $image = ActivityPhotos::findOrFail($id);
            $this->imageDelete($image->image_path);
            $image->delete();
            return $this->returnError("Image delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Image does not exists');
        }
    }
}
