<?php

namespace App\Http\Requests;
use App\Http\Requests\ApiRequest;

class RegistrationRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users|max:50',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
