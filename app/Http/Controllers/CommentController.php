<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Services\CommentServiceInterface;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentServiceInterface $commentService){
        $this->commentService = $commentService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCommentRequest $request
     * @return string
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|integer', 
            'comment' => 'required|string',
        ]);
    
        $commentData = [
            'user_id' => auth()->id(),
            'comment' => $validatedData['comment'],
            'posts_id' => $validatedData['post_id'], 
        ];
    
        $this->commentService->insert($request);
        // Redirect back to the post
        return redirect()->route('posts.postindex', $validatedData['post_id'])->with('success', __('messages.cmt_added_success'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $comment = $this->commentService->getCommentById($id);

        if (!$comment) {
            return redirect()->back()->with('failed', __('messages.404_not_found'));
        }
    
        return view('comment.edit', ['comment' => $comment]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCommentRequest $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(StoreCommentRequest $request,Posts $post, Comment $comment): RedirectResponse
    {
        $this->commentService->update($request, $comment);
        
        return redirect()->route('posts.postindex', Auth::user()->id)->with('success', __('messages.comment_updated_success'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->commentService->delete($id);
        return back();
    }
}
