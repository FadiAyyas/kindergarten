<?php

namespace App\Http\Requests\MobileApplications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class parentChildAbcenceRequest extends FormRequest
{

    use GeneralTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date'],
            'reason' => ['required', 'string'],
            'child_id' => ['required', 'numeric'],
        ];
        switch ($this->method()) {
            case 'POST': {
                    return  $rules;
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
