<?php
namespace App\Repository;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;

interface UserInterface 
{
    public function login(LoginRequest $data);
    public function register(RegistrationRequest $data);
    public function logout();
}