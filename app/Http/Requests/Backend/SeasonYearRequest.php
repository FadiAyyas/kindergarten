<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;
use Carbon\Carbon;
class SeasonYearRequest extends FormRequest
{
    use GeneralTrait;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'year' => ['required', 'max:2100' ,'numeric','min:'.date('Y').''],
            'seasonStartDate' => ['required','before:seasonEndDate','date','after:'.now().''],
            'seasonEndDate' => ['required','date','after:'.now().''],
            'season_id' => ['required','numeric','min:1'],
        ];
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
