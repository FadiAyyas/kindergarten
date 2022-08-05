<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class ClassRequest extends FormRequest
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
            'class_name' => ['required', 'max:55' ,'string'],
            'maxCapacity' => ['required', 'max:60','numeric','min:5'],
            'level_id' => ['required', 'max:16','numeric','min:1'],
            'employee_id' => ['required', 'numeric','unique:teacher_classes,employee_id'],
        ];

        if ($this->id) {
            $rules = [
                'class_name' => ['required', 'max:55' ,'string'],
                'maxCapacity' => ['required', 'max:60','numeric','min:5'],
                'level_id' => ['required', 'max:16','numeric','min:1'],
                'employee_id' => ['required', 'numeric'],
            ];
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
