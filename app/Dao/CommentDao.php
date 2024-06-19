<?php

namespace App\Dao;

use App\Contracts\Dao\CommentDaoInterface;
use App\Models\Comment;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Support\Collection;

class CommentDao implements CommentDaoInterface
{
    /**
     * Get comment by post id
     *
     * @param integer $postId
     * @return Collection
     */
    public function getCommentByPostId(int $postId): Collection
    {
        $comments = Posts::find($postId)->comments;
        return $comments;
    }

    /**
     * Get comment by user id
     *
     * @param integer $userId
     * @return Collection
     */
    public function getCommentByUserId(int $userId): Collection
    {
        $user = User::find($userId);
        $comments = $user->comments()->get()->groupBy('post_id');
        return $comments;
    }

    /**
     * get comment by comment id
     *
     * @param integer $id
     * @return Comment
     */
    public function getCommentById(int $id): Comment
    {   
        return Comment::with('user')->findOrFail($id);
    }

    /**
     * Insert new comment into table
     *
     * @param array $insertData
     * @return Comment
     */
    public function insert(array $insertData): Comment
    {
        $post = Comment::create($insertData);
        return $post->id;
    }

    /**
     * Delete comment
     *
     * @param integer $id
    * @return void
     */
    public function delete(int $id): void
    {
        Comment::where('id', $id)->delete();
    }

    /**
     * Update comment
     *
     * @param integer $id
     * @param array $updateData
     * @return int
     */
    public function update(int $id, array $updateData): int
    {
        return Comment::where('id', $id)->update($updateData);
    }
}
