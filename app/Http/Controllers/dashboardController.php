<?php

namespace App\Http\Controllers;

use App\Models\taskModel;
use App\Models\categoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{

    private $taskModel;
    private $categoryModel;

    public function __construct()
    {
        $this->taskModel = new taskModel();
        $this->categoryModel = new categoryModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $tasks      = $this->taskModel->GetAllTasksById($userId);
        $categories = $this->categoryModel->GetAllCategoriesById($userId);

        return view('dashboard', [
            'tasks'      => $tasks,
            'categories' => $categories
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
