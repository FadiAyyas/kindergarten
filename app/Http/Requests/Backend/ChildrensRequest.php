<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\GeneralTrait;

class ChildrensRequest extends FormRequest
{

    use GeneralTrait;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if(!$this->child_id)
        {
            $rules = [
                'childrens.*.childName' => ['required', 'max:24', 'string'],
                'childrens.*.birthDate' => ['required', 'max:24', 'date'],
                'childrens.*.gender' => ['required','string'],
                'childrens.*.childAddress' =>  ['required', 'string'],
                'childrens.*.medicalNotes' => ['required', 'string'],

                'childrens.*.class_id' =>  ['required', 'numeric'],
                'childrens.*.season_year_id' => ['required', 'numeric'],
                'childrens.*.ChildImage' => ['required', 'file', 'mimes:jpg,jpeg,png,gif', 'max:3000']
            ];
        }
        else
        {
            $rules = [
                'childName' => ['required', 'max:24', 'string'],
                'birthDate' => ['required', 'max:24', 'date'],
                'gender' => ['required','string'],
                'childAddress' =>  ['required', 'string'],
                'medicalNotes' => ['required', 'string'],
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
