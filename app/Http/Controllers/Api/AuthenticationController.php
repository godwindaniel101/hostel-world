<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;
use App\Http\Controllers\Api\BaseController;

class AuthenticationController extends BaseController
{
    public function register(RegistrationRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return $this->sendResponse($user, 'User register successfully.', 201);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->all())) {
            return $this->sendError(null, 'incorrect username or password.', 422);
        }
        
        $user = Auth::user();
        $user['token'] =  $user->createToken('token')->accessToken;
        return $this->sendResponse($user, 'User login successfully.');
    }

    public function logout()
    {
        $user = Auth::user();
        $user = $user->token();
        $user->revoke();
        return $this->sendResponse(null, 'User logged out successfully.');
    }
}
