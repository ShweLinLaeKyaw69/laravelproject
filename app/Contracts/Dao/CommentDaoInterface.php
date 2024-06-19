<?php

namespace App\Contracts\Dao;

interface CommentDaoInterface
{
    public function getCommentByPostId(int $postId);

    public function getCommentByUserId(int $userId);

    public function getCommentById(int $id);

    public function insert(array $insertData);

    public function delete(int $id);

    public function update(int $id, array $updateData);
}
