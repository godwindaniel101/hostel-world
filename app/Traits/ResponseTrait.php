<?php

namespace App\Traits;
use App\Utilities\Helpers;
use Illuminate\Support\Facades\Log;

trait ResponseTrait {
    public function sendSuccess($data, $message, $code = 200)
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