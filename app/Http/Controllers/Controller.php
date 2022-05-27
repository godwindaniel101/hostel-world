<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Hostel World",
 *    version="1.0.0",
 * )
 * 
 * @OA\SecurityScheme(
 *    securityScheme="token",
 *    in="header",
 *    name="token",
 *    type="https",
 *    scheme="bearer",
 *    bearerFormat="JWT",
 * ),
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
