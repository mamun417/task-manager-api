<?php

namespace App\Http\Controllers\ApiAuth;

use App\Http\Controllers\ApiController;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return $this->errorMessage('email or password does not match', 404);
    }

    public function me()
    {
        $userInfo = $this->guard()->user();

        return $this->successResponse(['user' => $userInfo], 200);
    }

    public function logout()
    {
        $this->guard()->logout();
        return $this->successMessage('successfully logged out', 200);
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    public function respondWithToken($token)
    {
        $data = [
            'user' => $this->guard()->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];

        return $this->successResponse($data, 200);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
