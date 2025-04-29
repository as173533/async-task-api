<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTask;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function submitTask(Request $request)
    {
        $request->validate([
            'n' => 'required|integer|min:1'
        ]);

        $task = Task::create([
            'id' => (string) Str::uuid(),
            'status' => 'pending',
            'input' => $request->only('n'),
        ]);

        ProcessTask::dispatch($task->id);

        return response()->json([
            'task_id' => $task->id,
            'status' => $task->status
        ]);
    }

    public function getTaskStatus($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json([
            'task_id' => $task->id,
            'status' => $task->status
        ]);
    }

    public function getTaskResult($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        if ($task->status !== 'completed') {
            return response()->json(['error' => 'Task not completed yet'], 400);
        }

        return response()->json([
            'task_id' => $task->id,
            'result' => $task->result
        ]);
    }
}
