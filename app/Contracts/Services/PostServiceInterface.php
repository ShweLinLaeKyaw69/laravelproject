<?php
namespace App\Contracts\Services;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

interface PostServiceInterface
{
    public function insert(StorePostRequest $request);

    public function getAllPost();

    public function getPostById(int $id);

    public function update(UpdatePostRequest $request);

    public function delete(int $id);

    public function verifyPostExists(Request $request);
}
