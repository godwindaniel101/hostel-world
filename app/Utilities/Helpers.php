<?php

namespace App\Utilities;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Helpers
{
    public function errorResponder($data = null, $statusCode = 400, $message = 'Action was Unsuccessfull')
    {
        $result = [
            'success' =>  false,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($result, $statusCode);
    }

    public function successResponder($data = null, $statusCode=200, $message = 'Action was Successfull')
    {
        $result = [
            'success' =>  true,
            'data' => $data,
            'message' => $message
        ];

        return response()->json($result, $statusCode);
    }

    public function paginate($items, $page)
    {
        $perPage = 20;
        $offSet = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(
            array_slice($items, $offSet, $perPage, true),
            count($items),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }
}
