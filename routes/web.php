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
    Route::get('detail/{id}', 'show')->name('detail')->middleware(VerifyUserExists::class);
    Route::get('edit/{id}', 'edit')->name('edit')->middleware([VerifyUserExists::class]);
    Route::post('update', 'update')->name('update');
    Route::get('delete/{id}', 'destroy')->name('delete')->middleware([VerifyUserExists::class]);
});


Route::get('logout', [AuthController::class, 'logout'])->name('logout');
