<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::post('/register',[RegisterController::class,'register']);

Route::middleware(['auth:api'])->group( function() {

        // Route::get('/category',[CategoryController::class,'index'])->middleware(['role:Admin']);
        Route::get('/category',[CategoryController::class,'index'])->middleware(['can:category.view']);
        Route::post('/category',[CategoryController::class,'store'])->middleware(['can:category.create']);
        Route::get('/category/{id}',[CategoryController::class,'show'])->middleware(['can:category.view']);
        Route::post('/category-update',[CategoryController::class,'update'])->middleware(['can:category.update']);
        Route::delete('/category_delete/{id}',[CategoryController::class,'destroy'])->middleware(['can:category.delete']);
    
    
        Route::controller(TaskController::class)->group(function(){
            Route::get('/task','index')->middleware(['role:Admin']);
            Route::post('/task','store')->middleware(['can:task.create']);
            Route::get('/task/{id}','show')->middleware(['can:task.view']);
            Route::post('/task-update','update')->middleware(['can:task.update']);
            Route::delete('/task/{id}','delete')->middleware(['can:task.delete']);
        });


});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
