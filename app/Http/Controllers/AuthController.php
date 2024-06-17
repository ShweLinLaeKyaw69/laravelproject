<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\View\View;
use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    protected $authService;
    protected $userService;
    
    public function __construct(AuthServiceInterface $authService, UserServiceInterface $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function authenticate(Request $request): RedirectResponse
    {
        Auth::logout();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('posts.postindex', Auth::user()->id);
        }

        return back()->withErrors(
            [
                'email' => 'The provided credentials do not match our records.'
            ]
        )->onlyInput('email');
    }


    public function create(): View
    {
        return view('auth.login');
    }


    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('auth.login');
    }


    public function changePassword(int $id): mixed
{
    $user = $this->userService->getUserById($id);
    return view('auth.changepassword', ['user' => $user]);
}


public function changePasswordStore(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8|max:255',
            'new_password_confirmation' => 'required|min:8|max:255'
        ]);

        $auth = Auth::user();

        if ($auth) {
            if (Hash::check($request->current_password, $auth->password)) {
                if (Hash::check($request->new_password, $auth->password)) {
                    return back()->withErrors("New password cannot be the same with as your current password");
                }
                $this->authService->storeChangedPassword($request->new_password, $auth->id);
                return redirect()->route('users.index', $auth->id);
            } elseif (!Hash::check($request->current_password, $auth->password)) {
                return back()->withErrors("Current password is incorrect.");
            } else {
                return back()->withErrors("Something went wrong.");
            }
        } else {
            return back()->withErrors("User isn't authenticated.");
        }
    }

    public function forgotpassword(): View
    {
        return view('auth.forgotpassword');
    }
     
    public function PostForgotPassword(Request $request)
    {
       dd($request->all());
    }

    public function resetPassword(string $token): View
    {
        return view('auth.resetPassword', ['token' => $token]);
    }
    
    public function resetPasswordStore(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'email' => 'required|email'
        ]);

        $this->authService->storeResetPassword($request);
        return redirect()->route('loginScreen')->with(['success' => 'Password reset successful.']);
    }
}
