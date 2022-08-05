<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class BusesRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        if(!$this->id)
        {
            $rules = [
                'employee_id' => ['required', 'numeric','unique:buses,employee_id'],
                'driverName' => ['required', 'string','max:22'],
                'driverPhoneNumber' => ['required','min:6', 'numeric'],
                'busTypeName' => ['required', 'string','max:255'],
                'plateNumber' => ['required','min:6', 'numeric'],
                'busItinerary_id' => ['required', 'numeric'],
            ];
        }
        if ($this->id) {
            $rules = [
                'employee_id' => ['required', 'numeric'],
                'driverName' => ['required', 'string','max:22'],
                'driverPhoneNumber' => ['required','min:6', 'numeric'],
                'busTypeName' => ['required', 'string','max:255'],
                'plateNumber' => ['required','min:6', 'numeric'],
                'busItinerary_id' => ['required', 'numeric'],
            ];
        }

        switch ($this->method()) {
            case 'POST': {
                    return $rules;
                }
            case 'PUT':
            case 'PATCH': {
                    return  $rules;
                }
            default:
                break;
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->returnError($validator->errors()));
    }
}
