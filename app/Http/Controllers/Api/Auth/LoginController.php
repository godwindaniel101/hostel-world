<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Api\BaseController;
use App\Repository\UserInterface;

class LoginController extends BaseController
{
    public function __construct(UserInterface $userInterface)
    {
        $this->user = $userInterface;
    }
    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(
     *              property="email", 
     *              type="string", 
     *              format="email", 
     *              example="user1@mail.com"
     *              ),
     *       @OA\Property(
     *              property="password", 
     *              type="string", 
     *              format="password", 
     *              example="PassWord12345"),
     *              ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Correct credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="true"
     *              ),
     *       @OA\Property(
     *              property="data", 
     *              type="object", 
     *              @OA\Property(
     *              property="id", 
     *              type="integer", 
     *              readOnly="true", 
     *              example="1"
     *              ),
     *      @OA\Property(
     *              property="name", 
     *              type="string", 
     *              example="John"
     *              ),
     *      @OA\Property(
     *              property="email", 
     *              type="string", 
     *              readOnly="true", 
     *              format="email", 
     *              description="User unique email address",
     *              example="user@gmail.com"
     *              ),
     *      @OA\Property(
     *              property="email_verified_at", 
     *              type="string", 
     *              readOnly="true", 
     *              format="date-time", 
     *              description="Datetime marker of verification status", 
     *              example="2019-02-25 12:59:20"
     *              ),
     *      @OA\Property(
     *              property="created_at", 
     *              type="string", 
     *              format="date-time", 
     *              description="Initial creation timestamp", 
     *              readOnly="true"
     *              ),
     *              @OA\Property(
     *              property="updated_at", 
     *              type="string", 
     *              format="date-time", 
     *              description="Last update timestamp", 
     *              readOnly="true"
     *              ),
     *      @OA\Property(
     *              property="token", 
     *              type="string"
     *              ),
     *              ),
     *       @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="User login successfully."
     *              )
     *        )
     *     )
     * )
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="false"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              default="null"
     *              ),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="incorrect username or password."
     *              ),
     *        )
     *  )
     */
    public function login(LoginRequest $request)
    {
        return $this->user->login($request);
    }
    /**
     * @OA\Delete(
     * path="/api/logout",
     * security={{ "token": {} }},
     * summary="Logout",
     * description="Logout user and invalidate token",
     * operationId="authLogout",
     * tags={"Authentication"},
     * @OA\Response(
     *    response=200,
     *    description="Successful log out",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="true"),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              default="null"),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="User logged out successfully."),
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Unathenticated logout attempt",
     *    @OA\JsonContent(
     *         @OA\Property(
     *              property="success", 
     *              type="boolean" , 
     *              default="false"
     *              ),
     *         @OA\Property(
     *              property="data", 
     *              type="object", 
     *              default="null"),
     *         @OA\Property(
     *              property="message", 
     *              type="string", 
     *              example="Unauthenticated."
     *              ),
     *        )
     *     )
     * )
     */
    public function logout()
    {
        return $this->user->logout();
    }
}
