<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class EventRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'term' => 'sometimes',
            'date' => 'sometimes|date_format:Y-m-d|date|after:yesterday'
        ];
    }

    public function messages()
    {
        return [
            'date.after' =>  "date has to be " . now()->format('Y-m-d') . " or futher."
        ]; 
    }
}
