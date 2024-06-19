<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CSVController;
use App\Http\Middleware\CommentOwner;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\VerifyUserExists;
use App\Http\Middleware\VerifyPostExists;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\PostOwner;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/post', function () {
    return view('posts.index');
});

Auth::routes();

// Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'create')->name('loginScreen');
    Route::post('login', 'authenticate')->name('login');
    Route::get('changePassword/{id}', 'changePassword')->name('changePasswordScreen')->middleware([VerifyUserExists::class]);
    Route::post('changePassword', 'changePasswordStore')->name('changePassword');
    Route::get('forgotpassword', 'forgotPassword')->name('password.request');
    Route::post('reset-password', 'resetPasswordStore')->name('password.update');

});

Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('index', 'index')->name('index');
    Route::get('/user/detail', 'showDetailForm')->name('showdetail');
    Route::get('/users/{userId}/detailcommentform', 'showDetailcommentform')->name('showDetailcommentform');
    Route::get('detail/{id}', 'show')->name('detail')->middleware(VerifyUserExists::class);
    Route::get('edit/{id}', 'edit')->name('edit')->middleware([VerifyUserExists::class]);
    Route::post('update', 'update')->name('update');
    Route::get('delete/{id}', 'destroy')->name('delete')->middleware([VerifyUserExists::class]);
});

Route::prefix('posts')->controller(PostController::class)->name('posts.')->group(function () {
    Route::get('index/{id}', 'index')->name('postindex');
    Route::get('index', 'showUserDetail')->name('showUserDetail');
    Route::get('create', 'create')->name('create')->middleware('auth');
    Route::get('{id}', 'show')->name('show')->middleware([VerifyPostExists::class]);
    Route::post('create', 'store')->name('store');
    Route::get('edit/{id}', 'edit')->name('edit')->middleware([VerifyPostExists::class]);
    Route::post('edit', 'update')->name('update');
    Route::get('delete/{id}', 'destroy')->name('delete')->middleware([VerifyPostExists::class]);
});

Route::prefix('comment')->controller(CommentController::class)->name('comment.')->group(function () {
    Route::post('posts', 'store')->name('store');
    Route::get('comments/delete/{id}', 'destroy')->name('delete');
    Route::get('edit/{id}', 'edit')->name('edit');
    Route::post('update/{id}', 'update')->name('update');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');
