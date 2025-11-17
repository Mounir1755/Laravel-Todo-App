<?php

namespace App\Http\Controllers;

use App\Models\taskModel;
use Illuminate\Http\Request;

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
        $tasks = $this->taskModel->GetAllTasks();
        
        // dd($tasks);
        return view('home', [
            'tasks' => $tasks
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
