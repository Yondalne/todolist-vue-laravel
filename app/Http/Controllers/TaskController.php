<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            "status" => true,
            "tasks" => auth()->user()->tasks->groupBy("status")
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
               'status' => false,
               "message" => $validator->errors(),
            ]);
        }
        $value = $request->all();
        $value["user_id"] = auth()->user()->id;
        $task = Task::create($value);

        return response()->json([
           'status' => true,
           "tasks" => auth()->user()->tasks->groupBy("status")
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $task = Task::find($id);
        if (empty($task)) {
            return response()->json([
              'status' => false,
               "code" => 404,
               "message" => "Task not found",
            ]);
        }
        if (auth()->user()->id != $task->user_id) {
            return response()->json([
                "status" => false,
                "message" => "unauthorized"
            ]);
        }

        $task->fill($request->all());
        // dd($task);
        $deadline = Carbon::parse($task->deadline);
        $task->deadline = $deadline->format("Y-m-d");
        $task->update();
        return response()->json([
           'status' => true,
            "code" => 200,
            "message" => "Task updated successfully",
            "tasks" => auth()->user()->tasks->groupBy("status")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::find($id);
        if (empty($task)) {
            return response()->json([
              'status' => false,
               "code" => 404,
               "message" => "Task not found",
            ]);
        }
        if (auth()->user()->id != $task->user_id) {
            return response()->json([
                "status" => false,
                "message" => "unauthorized"
            ]);
        }
        $task->delete();
        return response()->json([
            'status' => true,
            "code" => 200,
            "tasks" => auth()->user()->tasks->groupBy("status")
        ]);
    }

    public function completeTask($id)
    {
        $task = Task::find($id);
        if (auth()->user()->id != $task->user_id) {
            return response()->json([
                "status" => false,
                "message" => "unauthorized"
            ]);
        }
        $task->update(["status" => "completed"]);
        return response()->json([
            'status' => true,
            "code" => 200,
            "tasks" => auth()->user()->tasks->groupBy("status")
        ]);
    }
}
