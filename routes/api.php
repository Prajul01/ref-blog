<?php
//
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\API\ClientController;
//use App\Http\Controllers\API\TeamMemberController;
//use App\Http\Controllers\API\BlogController;
//use App\Http\Controllers\API\CategoryController;
//use App\Http\Controllers\API\VirtualEmployeeController;
//use App\Http\Controllers\API\OutsourcingController;
//use App\Http\Controllers\API\ContactUSController;
//use App\Http\Controllers\API\CommentController;
//use App\Http\Controllers\API\ProjectController;
//
///*
//|--------------------------------------------------------------------------
//| API Routes
//|--------------------------------------------------------------------------
//|
//| Here is where you can register API routes for your application. These
//| routes are loaded by the RouteServiceProvider and all of them will
//| be assigned to the "api" middleware group. Make something great!
//|
//*/
//
//
//
//
////Route::middleware(['auth:sanctum'])->group(function () {
//    Route::resource('client',ClientController::class)->except(['index']);
//    Route::resource('category',CategoryController::class)->except(['index']);
//    Route::resource('team',TeamMemberController::class)->except(['index']);
//    Route::resource('blog',BlogController::class)->except(['index']);
//    Route::resource('project',ProjectController::class)->except(['index']);
//    Route::resource('comment',CommentController::class)->except(['index']);
//    Route::resource('contact',ContactUSController::class)->except(['index']);
//    Route::resource('outsourcing',OutsourcingController::class)->except(['index']);
//    Route::resource('virtualEmployee',VirtualEmployeeController::class)->except(['index']);
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });
//
//
////});
//Route::post('login', [\App\Http\Controllers\API\AuthenticateController::class, 'login']);
//Route::post('register', [\App\Http\Controllers\API\AuthenticateController::class, 'register']);
//Route::get('client',[ClientController::class,'index']);
//Route::get('category',[CategoryController::class,'index']);
//Route::get('team',[TeamMemberController::class,'index']);
//Route::get('blog',[BlogController::class,'index']);
//Route::get('project',[ProjectController::class,'index']);
//Route::get('comment',[CommentController::class,'index']);
//Route::get('contact',[ContactUSController::class,'index']);
//Route::get('outsourcing',[OutsourcingController::class,'index']);
//Route::get('virtualEmployee',[VirtualEmployeeController::class,'index']);
//Route::resource('services',\App\Http\Controllers\API\ServicesController::class);
//
