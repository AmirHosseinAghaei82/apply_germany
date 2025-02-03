<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'first_name' => 'required|persian_alpha|max:64',
            'last_name'  => 'required|persian_alpha|max:84',
            'password'   => 'required|min:8|max:64|confirmed'
        ];

    }
}
