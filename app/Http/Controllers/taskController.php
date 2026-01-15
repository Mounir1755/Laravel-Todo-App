<?php

namespace App\Http\Controllers;

use App\Models\taskModel;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class taskController extends Controller
{

    private $taskModel;

    public function __construct()
    {
        $this->taskModel = new taskModel;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        
        $tasks = $this->taskModel->GetAllTasksById($userId);

        // dd($tasks);
        return view('dashboard', [
            'tasks' => $tasks
        ]);
    }

    public function APIGetTasks()
    {
        $tasks = $this->taskModel->GetAllTasksById(Auth::Id());
        // dd($tasks);
        return response()->json($tasks);
    }

    public function trashbin()
    {
        $userId = Auth::id();

        $deletedtasks = $this->taskModel->GetAllTasksById($userId);

        $trashbin = [];

        foreach ($deletedtasks as $task) {
            if ($task->isActive == 0) {
                $trashbin[] = $task;
            }
        }

        // dd($trashbin);

        return view('trashbin', [
            'trashbin' => $trashbin
        ]);
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
        $data = $request->validate([
            'categoryId'  => 'nullable',
            'title'       => 'required|string',
            'description' => 'nullable|string'
        ]);

        $data['userId'] = Auth::id();

        // if ($data['categoryId']) {
        //     $this->taskModel->AddTaskToCategory($data['categoryId']);
        // }

        $this->taskModel->CreateNewTask($data);
        
        return redirect()->route('dashboard')
                         ->with('Success', 'New task made!');
    }

    /**
     * Link a task to a category
     */
    public function addTaskToCategory(Request $request)
    {
        $data = $request->validate([
             'categoryId' => 'required'
            ,'taskId'     => 'required'
        ]);

        $this->taskModel->AddTaskToCategory($data);

        return redirect()->route('dashboard')
                         ->with('Success', 'Task linked!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $oldData = $this->taskModel->GetTaskinfoById($id);
        // dd($oldData);
        return view('task.edit', [
            'oldData' => $oldData
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $newData = $request->validate([
             'title'        => 'required|string'
            ,'description'  => 'nullable|string'
        ]);

        $this->taskModel->UpdateTask($id, $newData);

        return redirect()->route('dashboard')
                         ->with('Success', 'Task edited!');
    }
    
    /**
     * Mark task as done.
     */
    public function done($id) 
    {
        $this->taskModel->MarkAsDone($id);

        return redirect()->route('dashboard');
    }

    public function softDelete($id)
    {
        $this->taskModel->SoftDelete($id);

        return redirect()->route('dashboard')
                         ->with('Success', 'Task moved to taskbin!');
    }

    public function retreive($id)
    {
        $this->taskModel->RetreiveTask($id);

        return redirect()->route('dashboard')
                         ->with('Success', 'Task moved to dashboard!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->taskModel->DeleteTask($id);

        return redirect()->route('trashbin');
    }
}
