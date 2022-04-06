<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\UserController;
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
Route::prefix('admin')->group(function(){
    Route::get('/login', function () {
        return view('admin.content.login.index');
    })->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.auth');
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.content.dashboard.index');
        })->name('admin.dashboard');
        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
        // user
        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::resource('user', UserController::class)->except(['index', 'show', 'edit','create']);
        // post-category
        Route::get('/post-category', [PostCategoryController::class, 'index'])->name('admin.post.category');
        Route::resource('post-category', PostCategoryController::class)->except(['index', 'show', 'edit','create']);
    });
});
