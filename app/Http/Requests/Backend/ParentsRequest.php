<?php
namespace App\Http\Requests\Backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class ParentsRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'fatherName' => ['required', 'max:24', 'string'],
            'motherName' => ['required', 'max:24', 'string'],
            'fatherLastName' => ['required', 'max:24', 'string'],
        ];

        if (!$this->parent_id) {
            $rules += ['phoneNumbers.*.type'=>['required', 'string']];
            $rules += ['phoneNumbers.*.phoneNumber'=>['required', 'numeric','min:6']];
            $rules += ['email' => ['required', 'email','unique:parents,email']];
            $rules += ['password' => ['required', 'numeric','min:8']];
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
