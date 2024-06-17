<?php

namespace App\Http\Middleware;

use App\Contracts\Services\PostServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyPostExists
{
    protected $postService;
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->postService->verifyPostExists($request)) {
            return $next($request);
        } else {
            return redirect()->route('posts.index')->withErrors('Post does not exist.');
        }
    }
}
