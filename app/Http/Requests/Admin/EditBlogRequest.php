<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditBlogRequest extends FormRequest
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
            'image'       => 'required|file|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'alt'         => 'required'
        ];
    }
}
