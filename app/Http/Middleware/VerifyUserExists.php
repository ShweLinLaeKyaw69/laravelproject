<?php

namespace App\Http\Middleware;

use App\Contracts\Services\UserServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // Import RedirectResponse
use Symfony\Component\HttpFoundation\Response;

class VerifyUserExists
{
    protected $userService;
    
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->userService->verifyUserExists($request)) {
            return $next($request);
        } else {
            return redirect()->route('posts.postindex')->withErrors('User does not exist.');
        }
    }
}
