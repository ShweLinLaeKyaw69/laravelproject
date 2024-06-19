<?php

namespace App\Http\Middleware;

use App\Contracts\Services\CommentServiceInterface;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentOwner
{
    protected $commentService;

    function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            $user = Auth::user();
            $comment = $this->commentService->getCommentById($request->id);
            
            if ($request->id) {
                return $next($request);
            } else {
                return back()->withErrors('You can only modify your own comments.');
                } 
            }
        }
    }
