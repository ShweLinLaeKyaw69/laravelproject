<?php
namespace App\Services;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    protected $userDao;

    public function __construct(UserDaoInterface $userDaoInterface)
    {
        $this->userDao = $userDaoInterface;
    }

    public function insert(Request $request): void
    {
        $encrypted = Hash::make($request->password);

        $insertData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $encrypted
        ];
        $this->userDao->insert($insertData);
    }

    public function getUserById(int $id): User
    {
        $data = $this->userDao->getUserById($id);
        return $data;
    }

    public function delete(int $id): void
    {
        $this->userDao->delete($id);
    }

    public function update(Request $request): void
    {

        $updateData = [
            'name' => $request->name,
            'email' => $request->email
        ];
        $this->userDao->update($updateData, $request->id);
    }

    public function getAllUser(): Collection
    {
        return $this->userDao->getAllUser();
    }

    public function verifyUserExists(Request $request): bool
    {
        return $this->userDao->verifyUserExists($request);
    }

    public function getPostByUserId(int $userId): Collection
    {
        return $this->userDao->getPostByUserId($userId);
    }
}
