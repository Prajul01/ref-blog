<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ClientController;
use App\Http\Controllers\Backend\TeamMemberController;
use App\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\ProjectController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\VirtualEmployeeController;
use App\Http\Controllers\Backend\OutsourcingController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\ContributorsController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/admin', 'as' => 'admin.'], function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('blog',BlogController::class);
    Route::resource('category',CategoryController::class);
    Route::resource('client',ClientController::class);
    Route::resource('team',TeamMemberController::class);
    Route::resource('services',ServicesController::class);
    Route::resource('project',ProjectController::class);
    Route::resource('contactus',ContactUsController::class);
    Route::resource('virtual',VirtualEmployeeController::class);
    Route::resource('outsourcing',OutsourcingController::class);
    Route::resource('comment',CommentController::class);
    Route::resource('contributors',ContributorsController::class);
});
//Route::post('login', [App\Http\Controllers\HomeController::class, 'login'])->name('login.home');

Auth::routes();
