<?php

namespace App\Http\Requests;

use App\Utilities\Helpers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->formatResponse()
            ->errorResponder(null, 422, $validator->errors()->all()[0]);

        throw new HttpResponseException($response);
    }

    private function formatResponse()
    {
        return (new Helpers());
    }
}
