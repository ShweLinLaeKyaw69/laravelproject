<?php

namespace App\Services;

use App\Models\Comment;
use App\Contracts\Dao\CommentDaoInterface;
use App\Contracts\Services\CommentServiceInterface;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CommentService implements CommentServiceInterface
{

    protected $commentDao;
    public function __construct(CommentDaoInterface $commentDao)
    {
        $this->commentDao = $commentDao;
    }

    /**
     * Get comment by post id
     *
     * @param integer $postId
     * @return Collection
     */
    public function getCommentByPostId(int $postId): Collection
    {
        return $this->commentDao->getCommentByPostId($postId);
    }

    /**
     * Get comment by user id
     *
     * @param integer $userId
     * @return Collection
     */
    public function getCommentByUserId(int $userId): Collection
    {
        return $this->commentDao->getCommentByUserId($userId);
    }

    /**
     * Insert new comment into table
     *
     * @param StoreCommentRequest $request
     * @return string
     */
    public function insert(StoreCommentRequest $request): string
    {
        $insertArray = [
            'comment' => $request->user_comment,
            'user_id' => $request->user_id,
            'post_id' => $request->post_id
        ];
        $newComment = $this->commentDao->insert($insertArray);
        $user = Auth::user()->name;
        $userId = Auth::user()->id;

        $response = [
            'comment' => $newComment,
            'user' => $user,
            'userId' => $userId
        ];
        return $this->commentDao->insert($response);
    }

    /**
     * Delete comment
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->commentDao->delete($id);
    }

    /**
     * Update comment
     *
     * @param StoreCommentRequest $request
     * @return string
     */
    public function update(StoreCommentRequest $request): string
    {
        $this->commentDao->update($request->id, ["comment" => $request->comment]);
        $comment = $this->commentDao->getCommentById($request->id);

        return $comment->comment;

    }

    /**
     * get comment by id
     *
     * @param integer $id
     * @return Comment
     */
    public function getCommentById(int $id): Comment
    {
        return Comment::with('user')->findOrFail($id);
    }
}
