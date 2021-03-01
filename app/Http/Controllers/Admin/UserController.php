<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $users = User::latest()->paginate();
        return $this->successResponse(['users' => $users], 200);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'password' => 'required',
        ]);

        $requested_data = $request->only(['name', 'email', 'phone']);
        $requested_data['role_id'] = 2; // user role id
        $requested_data['password'] = Hash::make($request->password);

        $user = User::create($requested_data);

        return $this->successResponse(['user' => $user], 200);
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === 1) {
            return $this->errorMessage('Admin can not be update', 403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required',
            'password' => 'sometimes',
        ]);

        $requested_data = $request->only(['name', 'email', 'phone']);
        if ($request->password) {
            $requested_data['password'] = Hash::make($request->password);
        }

        $user->update($requested_data);

        return $this->successResponse(['product' => $user], 200);
    }

    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return $this->successResponse(['user' => ['id' => $user->id]], 200);
    }
}
