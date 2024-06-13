<?php
namespace App\Contracts\Dao;

use Illuminate\Http\Request;

interface UserDaoInterface
{
    public function insert(array $insertData);

    public function getUserById(int $id);

    public function delete(int $id);

    public function update(array $updateData, int $id);

    public function getAllUser();

    public function verifyUserExists(Request $request);

    public function storeResetPassword(Request $request);
    
    public function storeChangedPassword(string $password, int $id);
    
    public function getPostByUserId(int $userId);
}
