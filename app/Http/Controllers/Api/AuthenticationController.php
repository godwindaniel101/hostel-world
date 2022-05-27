<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;
use App\Http\Controllers\Api\BaseController;

class AuthenticationController extends BaseController
{
    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Sign in",
     * description="Login by email, password",
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
    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"auth"},
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
     *              @OA\Property(property="id", type="integer", readOnly="true", example="1"),
     *              @OA\Property(property="name", type="string", example="John"),
     *              @OA\Property(property="email", type="string", readOnly="true", format="email", description="User unique email address", example="user@gmail.com"),
     *              @OA\Property(property="email_verified_at", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
     *              @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
     *              @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
     *              @OA\Property(property="token", type="string"),
     *              ),
     *       @OA\Property(property="message", type="string", example="User login successfully.")
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
        if (!Auth::attempt($request->all())) {
            return $this->sendError(
                null,
                'incorrect username or password.',
                422
            );
        }

        $user = Auth::user();
        $user['token'] = $user->createToken('token')->accessToken;
        return $this->sendResponse($user, 'User login successfully.');
    }
    /**
     * @OA\Delete(
     * path="/api/logout",
     * security={{ "token": {} }},
     * summary="Logout",
     * description="Logout user and invalidate token",
     * operationId="authLogout",
     * tags={"auth"},
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
        $user = Auth::user();
        $user = $user->token();
        $user->revoke();
        return $this->sendResponse(null, 'User logged out successfully.');
    }
}
