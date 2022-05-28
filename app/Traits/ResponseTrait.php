<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ResponseTrait
{
    public function response($status, $data, $message, $code)
    {
        $response['status'] = $status;
        $response['data'] = $data;
        $response['message'] = $message;
        $response['code'] = $code;
        return (object)$response;
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
