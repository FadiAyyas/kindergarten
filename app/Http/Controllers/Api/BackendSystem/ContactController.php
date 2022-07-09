<?php

namespace App\Http\Controllers\Api\BackendSystem;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Backend\ContactRequest;
use App\Models\KgContact;
use App\Http\Traits\GeneralTrait;
use Throwable;

class ContactController extends Controller
{
    use GeneralTrait;
    public function store(ContactRequest $request)
    {
        $input = $request->all();
        try {
            KgContact::create($input);
            return $this->returnSuccessMessage('Contact created successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong, please try again late');
        }
    }

    public function update(ContactRequest $request, $id)
    {
        $input = $request->all();
        try {
            $data = KgContact::findOrFail($id);
            $data->update($input);
            return $this->returnSuccessMessage('Contact update successfully ');
        } catch (Throwable $e) {
            return $this->returnError('Something was wrong , Contact does not exists');
        }
    }

    public function destroy($id)
    {
        try {
            $data = KgContact::findOrFail($id);
            $data->delete();
            return $this->returnError("Contact delete successfully");
        } catch (Throwable $e) {
            return $this->returnError('Contact does not exists');
        }
    }
}
