<?php

use Illuminate\Support\Facades\Route;
Route::get('/login', [App\Http\Controllers\AuthLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthLoginController::class, 'login'])->name('login.submit');
Route::post('/logout', 'App\Http\Controllers\AuthLoginController@logout')->name('logout');

Route::middleware(['guest'])->group(function(){
    Route::get('/', function () {
        return redirect("/login");
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect("/dashboard");
    });
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/addTask', [App\Http\Controllers\TaskController::class, 'createTask'])->name('task.create');
    Route::get('/task', [App\Http\Controllers\TaskController::class, 'editor'])->name('task.editor');
    Route::post('/save/task', [App\Http\Controllers\TaskController::class, 'edit'])->name('task.update');
    Route::post('/delete/task', [App\Http\Controllers\TaskController::class, 'remove'])->name('task.remove');
});

Route::middleware(['auth', 'boss'])->group(function () {
    Route::post('/create_subordinate', [App\Http\Controllers\SubordinateController::class, 'store'])->name('subordinate.create');
    Route::post('/subordinates/addTask', [App\Http\Controllers\TaskController::class, 'createSubordinateTask'])->name('subordinate.createTask');
    Route::get('/subordinate', [App\Http\Controllers\SubordinateController::class, 'editor'])->name('subordinate.editor');
    Route::post('/delete/user', [App\Http\Controllers\SubordinateController::class, 'remove'])->name('subordinate.delete');
    Route::post('/save/user', [App\Http\Controllers\SubordinateController::class, 'edit'])->name('subordinate.update');
});
