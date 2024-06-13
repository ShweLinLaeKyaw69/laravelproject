<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\CommentOwner;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    Route::post('forgotpassword', 'PostForgotPassword')->name('PostForgotPassword');
    Route::post('reset-password', 'resetPasswordStore')->name('password.update');
    
});

Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('index', 'index')->name('index');
    Route::get('detail/{id}', 'show')->name('detail')->middleware(VerifyUserExists::class);
    Route::get('edit/{id}', 'edit')->name('edit')->middleware([VerifyUserExists::class]);
    Route::post('update', 'update')->name('update');
    Route::get('delete/{id}', 'destroy')->name('delete')->middleware([VerifyUserExists::class]);
});

Route::prefix('posts')->controller(PostController::class)->name('posts.')->group(function () {
    Route::get('index', 'index')->name('postindex');
    Route::get('create', 'create')->name('create')->middleware('auth');
    Route::get('{post_id}/{user_id}', 'show')->name('show')->middleware([VerifyPostExists::class]);
    Route::post('create', 'store')->name('store');
    Route::get('edit/{id}', 'edit')->name('edit')->middleware([VerifyPostExists::class]);
    Route::post('edit', 'update')->name('update');
    Route::get('delete/{id}', 'destroy')->name('delete')->middleware([VerifyPostExists::class]);
});

Route::controller(CommentController::class)->group(function(){
    Route::post('posts/{post_id}/comments/{user_id}', 'store')->name('posts.comment.store');
    Route::get('comments/delete/{id}', 'destroy')->middleware(CommentOwner::class)->name('comments.delete');
    Route::post('comments/update/{id}', 'update')->middleware(CommentOwner::class)->name('comments.update');
    
});


Route::get('logout', [AuthController::class, 'logout'])->name('logout');


