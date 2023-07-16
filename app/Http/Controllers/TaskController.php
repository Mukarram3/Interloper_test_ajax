<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return view('Admin.Tasks.index', compact('tasks'));
    }

    public function getTasksList(Request $request)
    {
        $Task = Task::all();
        return DataTables::of($Task)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return '<div class="btn-group">
                                              <button class="btn btn-sm btn-primary" data-id="' . $row['id'] . '" id="editTaskBtn">Update</button>
                                              <button class="btn btn-sm btn-danger" data-id="' . $row['id'] . '" id="deleteTaskBtn">Delete</button>
                                        </div>';
            })
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" name="task_checkbox" data-id="' . $row['id'] . '"><label></label>';
            })
            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), (new StoreTaskRequest)->rules(), (new StoreTaskRequest)->messages());

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $task = new Task();
            $task->title = $request->title;
            $task->description = $request->description;
            $task->priority = $request->priority;
            $task->due_date = $request->due_date;

            if ($task->save()) {
                return response()->json(['code' => 1, 'msg' => 'New Task has been successfully saved']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $task_id = $request->task_id;
        $taskDetails = Task::find($task_id);
        return response()->json(['details' => $taskDetails]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $task_id = $request->task_id;
        $validator = Validator::make($request->all(), (new UpdateTaskRequest())->rules(), (new UpdateTaskRequest())->messages());

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $task = Task::find($task_id);
            $task->title = $request->title;
            $task->description = $request->description;
            $task->priority = $request->priority;
            $task->due_date = $request->due_date;
            $query = $task->update();


            if ($query) {
                return response()->json(['code' => 1, 'msg' => 'Task Details have Been updated']);
            } else {
                return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $task_id = $request->task_id;
        $query = Task::find($task_id)->delete();

        if ($query) {
            return response()->json(['code' => 1, 'msg' => 'Task has been deleted from database']);
        } else {
            return response()->json(['code' => 0, 'msg' => 'Something went wrong']);
        }
    }

    public function deleteSelectedTasks(Request $request)
    {
        $task_ids = $request->task_ids;
        Task::whereIn('id', $task_ids)->delete();
        return response()->json(['code' => 1, 'msg' => 'Tasks have been deleted from database']);
    }
}
