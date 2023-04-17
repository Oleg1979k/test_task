<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostDoctorRequest extends FormRequest
{
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
        return [
            'surname' => 'alpha|required|max:20',
            'name' => 'alpha|required|max:20',
            'phone' => 'required|digits:10',
            'begin' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i',
            'patronymic_surname' => 'alpha|max:20',
            'birthday'  =>'date_format:Y-m-d',
            'email' => 'email'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true
        ], 422));
    }

}
