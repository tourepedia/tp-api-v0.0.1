<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\ResourceException;
use DB;
use Auth;
class TasksController extends Controller
{
    public function index()
    {
        return ["data" => Task::get()];
    }

    public function show(Request $request, $task)
    {
        try {
            $task = Task::findOrFail($task);
            return ["data" => $task];
        } catch (\Exception $e) {
            throw new NotFoundHttpException("Task not found.");
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "assigness" => "array",
        ]);

        if ($validator->fails()) {
            throw new ResourceException('Invalid request.', $validator->errors());
        }

        $creator = Auth::id();

        $task = new Task();
        $task->subject = $request->input("subject");
        $task->description = $request->input("description");
        $task->due_date = $request->input("due_date");
        $task->created_by = $creator;

        $assigness = $request->input("assigness");

        $toAttachAssigness = array();
        if ($assigness) {
            foreach ($assigness as $assignes) {
                $toAttachAssigness[$assignes] = ["created_by" => $creator];
            }
        }


        DB::beginTransaction();
        $task->save();
        if (count($toAttachAssigness)) {
            $task->allAssignees()->sync($toAttachAssigness);
        }
        DB::commit();

        return $this->show($request, $task->id);
    }
}
