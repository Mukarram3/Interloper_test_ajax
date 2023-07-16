<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'Tasks'], function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::get('/getTasksList', [TaskController::class, 'getTasksList'])->name('get.tasks.list');
        Route::post('/deleteTask', [TaskController::class, 'destroy'])->name('delete.task');
        Route::post('/deleteSelectedTasks', [TaskController::class, 'deleteSelectedTasks'])->name('delete.selected.tasks');
        Route::post('/add-task', [TaskController::class, 'store'])->name('create.task.details');
        Route::post('/getTaskDetails', [TaskController::class, 'edit'])->name('get.task.details');
        Route::post('/updateTaskDetails',[TaskController::class, 'update'])->name('update.task.details');

    });

});
