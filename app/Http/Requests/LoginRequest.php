<?php

namespace App\Http\Requests;
use App\Http\Requests\ApiRequest;

class LoginRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
