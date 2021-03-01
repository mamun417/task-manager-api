<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'phone' => 'required'
        ]);

        $requested_data = $request->only(['name', 'email', 'phone']);

        auth()->user()->update($requested_data);

        $user_info = auth()->user();

        return $this->successResponse(['user' => $user_info], 200);
    }

    public function checkPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required'
        ]);

        $check = Hash::check($request->old_password, auth()->user()->password);

        if ($check) {
            return $this->successMessage('password match', 200);
        }

        return $this->errorMessage('password does not match', 404);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        auth()->user()->update(['password' => Hash::make($request->password)]);

        $this->successMessage('password has been updated successful', 200);
    }

    public function changeImage(Request $request)
    {
        $request->validate([
            'image' => 'required'
        ]);

        $requested_data = $request->only('image');

        if ($request->image) {

            $image = HelperController::imageUpload('image');
            $requested_data['image'] = $image;

            if (isset(auth()->user()->image)) {
                HelperController::imageDelete(auth()->user()->image);
            }
        }

        auth()->user()->update($requested_data);

        $userInfo = auth()->user();

        return $this->successResponse(['user' => $userInfo], 200);
    }

    public function getTasks()
    {
        $tasks = auth()->user()->tasks;
        return $this->successResponse(['tasks' => $tasks], 200);
    }

    public function updateTaskStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $task->update($request->all());

        return $this->successResponse(['tasks' => $task], 200);
    }
}
