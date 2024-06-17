<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    /**
     * The user data access object.
     *
     * @var UserDaoInterface
     */
    protected $userDao;

    /**
     * Create a new instance of UserService.
     *
     * @param UserDaoInterface $userDaoInterface The user data access object
     * @return void
     */
    public function __construct(UserDaoInterface $userDaoInterface)
    {
        $this->userDao = $userDaoInterface;
    }

    /**
     * Insert a new user.
     *
     * @param Request $request The request object containing user data
     * @return void
     */
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

    /**
     * Get a user by ID.
     *
     * @param int $id The ID of the user
     * @return User The user model
     */
    public function getUserById(int $id): User
    {
        return $this->userDao->getUserById($id);
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id The ID of the user to delete
     * @return void
     */
    public function delete(int $id): void
    {
        $this->userDao->delete($id);
    }

    /**
     * Update a user's data.
     *
     * @param Request $request The request object containing updated user data
     * @return void
     */
    public function update(Request $request): void
    {
        $updateData = [
            'name' => $request->name,
            'email' => $request->email
        ];
        $this->userDao->update($updateData, $request->id);
    }

    /**
     * Get all users.
     *
     * @return Collection A collection of user models
     */
    public function getAllUser(): Collection
    {
        return $this->userDao->getAllUser();
    }

    /**
     * Verify if a user exists.
     *
     * @param Request $request The request object containing user data for verification
     * @return bool True if the user exists, false otherwise
     */
    public function verifyUserExists(Request $request): bool
    {
        return $this->userDao->verifyUserExists($request);
    }

    /**
     * Get posts by user ID.
     *
     * @param int $userId The ID of the user
     * @return Collection A collection of post models associated with the user
     */
    public function getPostByUserId(int $userId): Collection
    {
        return $this->userDao->getPostByUserId($userId);
    }
}
