<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\FileServiceInterface;
use App\Services\FileService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //User
        $this->app->bind('App\Contracts\Services\UserServiceInterface', 'App\Services\UserService');
        $this->app->bind('App\Contracts\Dao\UserDaoInterface', 'App\Dao\UserDao');

        //Auth
        $this->app->bind('App\Contracts\Services\AuthServiceInterface', 'App\Services\AuthService');

        //Post
        $this->app->bind('App\Contracts\Services\PostServiceInterface', 'App\Services\PostService');
        $this->app->bind('App\Contracts\Dao\PostDaoInterface', 'App\Dao\PostDao');

        //Comment
        $this->app->bind('App\Contracts\Services\CommentServiceInterface', 'App\Services\CommentService');
        $this->app->bind('App\Contracts\Dao\CommentDaoInterface', 'App\Dao\CommentDao');

        //File
        $this->app->bind(FileServiceInterface::class, FileService::class);    }

    public function boot(): void
    {
        //
    }
}
