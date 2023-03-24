<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\TeamMemberController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('client',ClientController::class);
Route::resource('category',CategoryController::class);
Route::resource('team',TeamMemberController::class);
Route::resource('blog',BlogController::class);
Route::resource('project',\App\Http\Controllers\API\ProjectController::class);
