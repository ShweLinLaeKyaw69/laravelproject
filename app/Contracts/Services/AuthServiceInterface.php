<?php
namespace App\Contracts\Services;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function sendForgotPasswordEmail(Request $request);

    public function storeResetPassword(Request $request);

    public function storeChangedPassword(string $password, int $id);
}
