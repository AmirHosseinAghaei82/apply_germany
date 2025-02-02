<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyMobileRequest extends FormRequest
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
            'otp'           => 'required|digits:6',
            'mobile_number' => 'required|iran_mobile'
        ];

    }


}
