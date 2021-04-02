<?php

use App\Http\Controllers\ToDoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/get', [ToDoController::class,"index"]);
Route::view("/","lists");
Route::post('/store', [ToDoController::class,"store"]);
Route::get('/task/{id}/edit', [ToDoController::class,"edit"]);
Route::post('/task/{id}/update', [ToDoController::class,"update"]);

Route::get('/task/{id}/mark-as-favorite', [ToDoController::class,"updateMarkAsFavorite"]);
Route::get('/task/{id}/mark-as-read', [ToDoController::class,"updateMarkAsRead"]);
Route::get('/task/{id}/delete', [ToDoController::class,"destroy"]);
Route::get('/task/arrangeOrder', [ToDoController::class,"arrangeOrder"]);
Route::get('/task/search', [ToDoController::class,"show"]);
