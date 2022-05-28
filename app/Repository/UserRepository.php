<?php

namespace App\Repository;

use App\Models\User;
use App\Traits\ResponseTrait;
use App\Repository\UserInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserInterface
{
    use ResponseTrait;

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login($request)
    {
        if (!Auth::attempt($request->all())) {
            return $this->sendError(null,'incorrect username or password.',422);
        }

        $user = Auth::user();
        $user['token'] = $user->createToken('token')->accessToken;
        return $this->sendSuccess($user, 'User login successfully.');
    }
    
    public function logout(){
        $user = Auth::user();
        $user = $user->token();
        $user->revoke();
        return $this->sendSuccess(null, 'User logged out successfully.');
    }

    public function register($request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user =  $this->model->create($input);
        return $this->sendSuccess($user, 'User register successfully.', 201);
    }
}
