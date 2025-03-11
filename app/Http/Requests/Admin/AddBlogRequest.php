<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddBlogRequest extends FormRequest
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
            'title'       => 'required',
            'description' => 'required',
            'content'     => 'required',
            'image'       => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt'         => 'required'
        ];

    }
}
