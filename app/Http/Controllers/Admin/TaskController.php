<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Subject;

class TaskController extends ApiController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $tasks = Task::with('user')->latest()->paginate();
        return $this->successResponse(['tasks' => $tasks], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required',
        ]);

        $requested_data = $request->only(['user_id', 'title', 'description', 'due_date']);

        $task = Task::create($requested_data);

        return $this->successResponse(['task' => $task], 200);
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required',
            'user_id' => 'required|numeric',
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required',
        ]);

        $requested_data = $request->only(['status', 'user_id', 'title', 'description', 'due_date']);

        $task->update($requested_data);

        return $this->successResponse(['task' => $task], 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return $this->successResponse(['task' => ['id' => $task->id]], 200);
    }

    public function getUsers(Task $task)
    {
        $users = User::latest()->get();
        return $this->successResponse(['users' => $users], 200);
    }
}
