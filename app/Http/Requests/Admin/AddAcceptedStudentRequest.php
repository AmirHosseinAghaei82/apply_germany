<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddAcceptedStudentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {

        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422));

    }

    public function rules(): array
    {

        return [
            'first_name' => 'required',
            'last_name'  => 'required',
            'field'      => 'required',
            'university' => 'required',
            'image'      => 'file|mimes:jpeg,png,jpg,gif,svg'
        ];

    }
    
}
