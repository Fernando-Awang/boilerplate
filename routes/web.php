<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
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
        Route::get('/dashboard',[DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
        // company-info
        Route::get('/company-info', [CompanyController::class, 'index'])->name('admin.company.info');
        Route::post('company-info/{id}', [CompanyController::class, 'update']);
        // user
        Route::get('/user', [UserController::class, 'index'])->name('admin.user');
        Route::resource('user', UserController::class)->except(['index', 'show', 'edit','create']);
        // post-category
        Route::get('/post-category', [PostCategoryController::class, 'index'])->name('admin.post.category');
        Route::resource('post-category', PostCategoryController::class)->except(['index', 'show', 'edit','create']);
        // post
        Route::get('/post', [PostController::class, 'index'])->name('admin.post');
        Route::get('/post/create', [PostController::class, 'create'])->name('admin.post.create');
        Route::get('/post/edit/{id}', [PostController::class, 'edit'])->name('admin.post.edit');
        Route::resource('post', PostController::class)->except(['index', 'edit','create', 'update']);
        Route::post('post/update/{id}', [PostController::class, 'update']);
        // gallery-category
        Route::get('/gallery-category', [GalleryCategoryController::class, 'index'])->name('admin.gallery.category');
        Route::resource('gallery-category', GalleryCategoryController::class)->except(['index', 'show', 'edit','create']);
        // gallery
        Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
        Route::resource('gallery', GalleryController::class)->except(['index', 'edit','show','create', 'update']);
        Route::post('gallery/update/{id}', [GalleryController::class, 'update']);
        // product-category
        Route::get('/product-category', [ProductCategoryController::class, 'index'])->name('admin.product.category');
        Route::resource('product-category', ProductCategoryController::class)->except(['index', 'show', 'edit','create']);
        // product
        Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
        Route::resource('product', ProductController::class)->except(['index', 'edit','create', 'update']);
        Route::post('product/update/{id}', [ProductController::class, 'update']);
    });
});
