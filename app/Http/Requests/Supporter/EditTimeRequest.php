<?php

namespace App\Http\Requests\Supporter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditTimeRequest extends FormRequest
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
            'start_time' => 'required|date_format:Y-m-d H:i',
            'end_time'   => 'required|date_format:Y-m-d H:i'
        ];
        
    }
}
