<?php

namespace App\Providers;

use App\Models\categoryModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new categoryModel();
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.layouts.app.sidebar', function ($view) {
            $userId = Auth::id();
            $categories = $this->categoryModel->GetAllCategoriesById($userId);

            $view->with('categories', $categories);
        });
    }
}
