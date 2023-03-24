<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\TeamMemberController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\ProjectController;
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::group(['prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('blog',BlogController::class);
    Route::resource('category',CategoryController::class);
    Route::resource('client',ClientController::class);
    Route::resource('team',TeamMemberController::class);
    Route::resource('services',ServicesController::class);
    Route::resource('project',ProjectController::class);
});
