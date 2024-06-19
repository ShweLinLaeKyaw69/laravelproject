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
            'post_id' => 'required|integer', // Validate the post_id
            'comment' => 'required|string',
        ]);
    
        $commentData = [
            'user_id' => auth()->id(),
            'comment' => $validatedData['comment'],
            'posts_id' => $validatedData['post_id'], // Use the post_id from the form data
        ];
    
        // Create the comment with the correct posts_id
        Comment::create($commentData);
    
        // Redirect back to the post
        return redirect()->route('posts.postindex', $validatedData['post_id'])->with('success', 'Comment added successfully!');
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
            abort(404, 'Comment not found');
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
