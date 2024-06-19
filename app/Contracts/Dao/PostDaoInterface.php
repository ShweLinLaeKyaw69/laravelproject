<?php
namespace App\Contracts\Dao;

use Illuminate\Http\Request;
use App\Http\Requests\CsvUploadRequest;

interface PostDaoInterface
{
    public function insert(array $insertData);

    public function getAllPost();

    public function getPublicPost();

    public function getPostById(int $postId);

    public function update(array $updateData, int $postId);

    public function delete(int $id);

    public function verifyPostExists(Request $request);

    public function csvImport(CsvUploadRequest $request);
}
