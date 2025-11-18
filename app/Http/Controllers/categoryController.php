<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categoryModel;
use Illuminate\Support\Facades\Auth;

class categoryController extends Controller
{

    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new categoryModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'categoryTitle' => 'required|string',
            'categoryDescription' => 'required|string'
        ]);

        $data['userId'] = Auth::id();
        
        $this->categoryModel->CreateNewCategory($data);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($Id)
    {
        $categoryInfo = $this->categoryModel->GetAllCategoryInfoById($Id);
        $categoryTasks = $this->categoryModel->GetAllTasksByCategoryId($Id);

        return view('category.show', [
             'categoryInfo' => $categoryInfo
            ,'categoryTasks' => $categoryTasks
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(categoryModel $categoryModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, categoryModel $categoryModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(categoryModel $categoryModel)
    {
        //
    }
}
