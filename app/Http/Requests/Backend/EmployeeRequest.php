<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use GeneralTrait;
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
            'firstName' => ['required', 'max:24', 'string'],
            'lastName' => ['required', 'max:24', 'string'],
            'phoneNumber' => ['required', 'numeric','min:6'],
            'gender' => ['required','string'],
            'address' =>  ['required', 'string'],
            'role' => ['required', 'string'],
            'age' => ['required', 'numeric'],
            'email' => ['required', 'email'],

        ];

        if (!$this->id) {
            $rules += ['photo' => ['required', 'file', 'mimes:jpg,jpeg,png,gif', 'max:3000']];
            $rules += ['password' => ['required', 'string','min:8']];
        }
        switch ($this->method()) {
            case 'POST': {
                    return $rules;
                }
            case 'PUT':
            case 'PATCH': {
                    return $rules;
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
