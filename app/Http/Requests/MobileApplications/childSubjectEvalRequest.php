<?php

namespace App\Http\Requests\MobileApplications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class childSubjectEvalRequest extends FormRequest
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
            'eval.*.subject_id' => ['required', 'numeric'],
            'eval.*.evaluation' => ['required', 'string'],
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
