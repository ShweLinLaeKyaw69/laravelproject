<?php
namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function insert(Request $request);

    public function getUserById(int $id);

    public function delete(int $id);

    public function update(Request $request);

    public function getAllUser();

    public function verifyUserExists(Request $request);

    public function getPostByUserId(int $userId);
}
