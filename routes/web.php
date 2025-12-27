<?php

use App\Http\Controllers\categoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('dashboard', [dashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', fn() => view('home'))->name('home');

Route::post('/task/store', [taskController::class, 'store'])->name('task.store');
Route::put('/task/{id}/done', [taskController::class, 'done'])->name('task.done');
Route::get('/task/{id}/edit', [taskController::class, 'edit'])->name('task.edit');
Route::put('/task/{id}/update', [taskController::class, 'update'])->name('task.update');

Route::delete('/trashbin/{id}', [taskController::class, 'destroy'])->name('trashbin.destroy');
Route::put('/trashbin/{id}/retreive', [taskController::class, 'retreive'])->name('trashbin.retreive');
Route::put('/task/{id}/softdelete', [taskController::class, 'softdelete'])->name('task.softdelete');
Route::get('trashbin', [taskController::class, 'trashbin'])->name('trashbin');

use Illuminate\Support\Facades\DB;

Route::get('/db-test', function () {
    return DB::connection()->getPdo()
        ? 'Railway DB connected ✅'
        : 'Railway DB failed ❌';
});


Route::post('/task/addTaskToCategory',  [taskController::class, 'addTaskToCategory'])->name('task.addTaskToCategory');


Route::get('/category/{id}/show', [categoryController::class, 'show'])->name('category.show');
Route::post('/category/store', [categoryController::class, 'store'])->name('category.store');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
