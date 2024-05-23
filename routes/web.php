<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', [TaskController::class, 'Index'])->name('index');
Route::post('/tasks', [TaskController::class, 'Store'])->name('tasks.store');
Route::get('edit_task/{ID}', [TaskController::class, 'Edit']);
Route::post('/task/update', [TaskController::class, 'Update'])->name('tasks.update');
Route::get('/delete/{id}', [TaskController::class, 'Delete'])->name('tasks.delete');