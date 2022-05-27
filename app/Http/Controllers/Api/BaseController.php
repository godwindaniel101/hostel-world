<?php

namespace App\Http\Controllers\Api;

use App\Utilities\Helpers;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    public function sendResponse($data, $message, $code = 200)
    {
        return (new Helpers())->successResponder($data, $code, $message);
    }
    public function sendError($error, $message = [], $code = 404)
    {
        return (new Helpers())->errorResponder($error, $code, $message);
    }
    public function log($request, $message)
    {
        Log::stack(['stdout', 'stack'])->info(
                [
                    'ip' => $request->ip(),
                    'url' => $request->path(),
                    'message' => $message
                ]
        );
        return;
    }
}
