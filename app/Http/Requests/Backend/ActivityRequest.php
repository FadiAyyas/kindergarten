<?php
namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class ActivityRequest extends FormRequest
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
            'activity_name' => ['required', 'max:24' ,'string'],
            'activity_description' => ['required', 'max:350','string'],
            'activity_date' => ['required','date'],
            'activity_price' => ['required','numeric','min:0'],
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
