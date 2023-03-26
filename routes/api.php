<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\TeamMemberController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\VirtualEmployeeController;
use App\Http\Controllers\API\OutsourcingController;
use App\Http\Controllers\API\ContactUSController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\ProjectController;

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
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('client',ClientController::class);
    Route::resource('category',CategoryController::class);
    Route::resource('team',TeamMemberController::class);
    Route::resource('blog',BlogController::class);
    Route::resource('project',ProjectController::class);
    Route::resource('comment',CommentController::class);
    Route::resource('contact',ContactUSController::class);
    Route::resource('outsourcing',OutsourcingController::class);
    Route::resource('virtualEmployee',VirtualEmployeeController::class);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('login', [\App\Http\Controllers\API\AuthenticateController::class, 'login']);
Route::post('register', [\App\Http\Controllers\API\AuthenticateController::class, 'register']);
