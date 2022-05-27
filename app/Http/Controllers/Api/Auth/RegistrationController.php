<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Requests\RegistrationRequest;
use App\Http\Controllers\Api\BaseController;

class RegistrationController extends BaseController
{
    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Register",
     * description="Register new user record",
     * operationId="authRegister",
     * tags={"auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"name","email","password", "password_confirmation"},
     *       @OA\Property(
     *              property="name", 
     *              type="string", 
     *              format="text", 
     *              example="John Doe"),
     *       @OA\Property(
     *              property="email", 
     *              type="string", 
     *              format="email",
     *              example="user1@mail.com"),
     *       @OA\Property(
     *              property="password", 
     *              type="string", 
     *              format="password", 
     *              example="PassWord12345"),
     *       @OA\Property(
     *              property="password_confirmation", 
     *              type="string", 
     *              format="password", 
     *              example="PassWord12345"
     * ),
     *    ),
     * ),
     *   @OA\Response(
     *     response=201,
     *     description="Success",
     *     @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="true"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              ref="#/components/schemas/User"),
     *         @OA\Property(
     *              property="message",
     *              type="string", 
     *              default="User register successfully."),
     *     )
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="false"),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              default="null"),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="The email has already been taken."),
     *        )
     *     )
     * )
     */
    public function register(RegistrationRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return $this->sendResponse($user, 'User register successfully.', 201);
    }
   
   
}
