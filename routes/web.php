<?php

use Livewire\Volt\Volt;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\taskController;
use App\Http\Controllers\teamController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\dashboardController;

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



Route::post('/task/addTaskToCategory',  [taskController::class, 'addTaskToCategory'])->name('task.addTaskToCategory');


Route::get('/team', [teamController::class, 'index'])->name('teams');
Route::get('/team/{id}/show', [teamController::class, 'show'])->name('team.show');
Route::get('/team/create', [teamController::class, 'create'])->name('team.create');
Route::get('/team/{id}/createTask', [teamController::class, 'createTask'])->name('team.createTask');
Route::post('/team/storeTask', [teamController::class, 'storeTask'])->name('team.storeTask');
Route::get('/team/{teamId}/task/{id}', [teamController::class, 'editTask'])->name('team.editTask');
Route::put('/team', [teamController::class, 'updateTask'])->name('team.updateTask');
Route::post('/team/store', [teamController::class, 'store'])->name('team.store');
Route::get('/team/{id}/addUsersToTeam', [teamController::class, 'addUsersToTeam'])->name('team.addUsersToTeam');
Route::post('/team/addUserToTeam', [teamController::class, 'addUserToTeam'])->name('team.addUserToTeam');


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
