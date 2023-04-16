<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;


Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('/logout', [DashboardController::class, 'logout']);
    //Tag
    Route::get('/tag', [TagController::class, 'index'])->name('admin.tag');
    Route::post('/tag/store', [TagController::class, 'store'])->name('admin.tag.store');
    Route::post('/tag/update/{id}', [TagController::class, 'update'])->name('admin.tag.update');
    Route::delete('/tag/destroy/{id}', [TagController::class, 'destroy'])->name('admin.tag.destroy');
    //Category
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
     //Role
     Route::get('/role', [RoleController::class, 'index'])->name('admin.role');
     Route::post('/role/store', [RoleController::class, 'store'])->name('admin.role.store');
     Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
     Route::delete('/role/destroy/{id}', [RoleController::class, 'destroy'])->name('admin.role.destroy');
     Route::post('/assign-roles', [RoleController::class, 'assign_role']);
     //User
     Route::get('/user', [UserController::class, 'index'])->name('admin.user');
     Route::post('/user/store', [UserController::class, 'store'])->name('admin.user.store');
     Route::post('/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
     Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

     Route::view('/assign-role', 'layouts.backend_app');

});



