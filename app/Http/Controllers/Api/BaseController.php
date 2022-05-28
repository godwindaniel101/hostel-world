<?php

namespace App\Http\Controllers\Api;

use App\Utilities\Helpers;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendSuccess($data, $message, $code = 200)
    {
        return (new Helpers())->successResponder($data, $code, $message);
    }
    public function sendError($error, $message = [], $code = 404)
    {
        return (new Helpers())->errorResponder($error, $code, $message);
    }
    public function formatResponse($response)
    {
        if (!$response->status) {
            return $this->sendError($response->data, $response->message, $response->code);
        }
        return $this->sendSuccess($response->data, $response->message, $response->code);
    }

}
