<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        Route::post('/change-status', [App\Http\Controllers\Admin\DashboardController::class, 'changeProductStatus']);
    });
//    Route::controller(App\Http\Controllers\User\DashboardController::class)->group(function () {
//        Route::get('get-categories', 'getCategories')
//            ->name('get.categories');
//        Route::get('get-products', 'getProducts')
//            ->name('get.products');
//        Route::get('get-category-list', 'getCategoryList')
//            ->name('get.category.list');
    Route::middleware('user')->group(function () {
        Route::get('get-categories', [App\Http\Controllers\User\DashboardController::class, 'getCategories'])
            ->name('get.categories');
        Route::get('get-products', [App\Http\Controllers\User\DashboardController::class, 'getProducts'])
            ->name('get.products');
        Route::get('get-category-list', [App\Http\Controllers\User\DashboardController::class, 'getCategoryList'])
            ->name('get.category.list');
        Route::get('/user/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index']);
        Route::post('/save-products', [App\Http\Controllers\User\DashboardController::class, 'addProduct']);
        Route::post('/save-categories', [App\Http\Controllers\User\DashboardController::class, 'addCategory']);
        Route::post('/delete-product', [App\Http\Controllers\User\DashboardController::class, 'deleteProduct']);
        Route::post('/delete-category', [App\Http\Controllers\User\DashboardController::class, 'deleteCategory']);
        Route::post('/edit-product', [App\Http\Controllers\User\DashboardController::class, 'updateProduct']);
        Route::post('/edit-category', [App\Http\Controllers\User\DashboardController::class, 'updateCategory']);
    });
});



