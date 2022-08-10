<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentController;


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


Route::get('/', [PagesController::class, 'index']);
Route::resource('/blog', PostsController::class);
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('/blog')->group(function () {
    Route::post('/{slug}/comment', [CommentController::class, 'store']);
});

//admin
Route::get('/admin/blog', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.index');
Route::get('/admin/blog/search', [\App\Http\Controllers\Admin\DashboardController::class, 'search'])->name('admin.search');
Route::delete('admin/blog/{slug}', [\App\Http\Controllers\Admin\DashboardController::class, 'destroy'])->name('admin.destroy');
