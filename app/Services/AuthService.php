<?php
namespace App\Services;

use App\Contracts\Dao\UserDaoInterface;
use App\Contracts\Services\AuthServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;


class AuthService implements AuthServiceInterface
{
    protected $userDao;

    public function __construct(UserDaoInterface $userDao)
    {
        $this->userDao = $userDao;
    }
    /**
     * Store new password
     *
     * @param Request $request
     * @param User $auth
     * @return void
     */
    public function storeChangedPassword(string $password, int $id): void
    {
        $this->userDao->storeChangedPassword($password, $id);
    }

    /**
     * Send password reset email
     *
     * @param Request $request
     * @return string
     */
    public function sendForgotPasswordEmail(Request $request): string
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status;
    }

    /**
     * Store new password from reset form
     *
     * @param Request $request
     * @return void
     */
    public function storeResetPassword(Request $request): void
    {
        $this->userDao->storeResetPassword($request);
    }
}
