<?php

namespace App\Contracts\Services;

use App\Http\Requests\StoreCommentRequest;

interface CommentServiceInterface
{
    public function getCommentByPostId(int $postId);

    public function getCommentByUserId(int $userId);

    public function insert(StoreCommentRequest $request);

    public function delete(int $id);

    public function update(StoreCommentRequest $request);

    public function getCommentById(int $id);
}
