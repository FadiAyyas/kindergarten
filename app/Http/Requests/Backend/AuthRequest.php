<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class AuthRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'max:50', 'string'],
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
