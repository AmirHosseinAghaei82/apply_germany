<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditDashboardRequest extends FormRequest
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
            'first_name'    => 'nullable|persian_alpha|max:64',
            'last_name'     => 'nullable|persian_alpha|max:84',
            'password'      => 'nullable|min:8|max:64|confirmed',
            'iamge'         => 'nullable|file|mimes:png,jpeg,jpg,gif,svg|max:2048',
        ];
    }
}
