<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    protected $authService;
    protected $userService;

    /**
     * Create a new AuthController instance.
     *
     * @param  \App\Contracts\Services\AuthServiceInterface  $authService
     * @param  \App\Contracts\Services\UserServiceInterface  $userService
     * @return void
     */
    public function __construct(AuthServiceInterface $authService, UserServiceInterface $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Authenticate the user based on given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }

    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Logout the currently authenticated user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('auth.login');
    }

    /**
     * Display the change password form for the specified user.
     *
     * @param  int  $id The ID of the user.
     * @return \Illuminate\View\View
     */
    public function changePassword(int $id): View
    {
        $user = $this->userService->getUserById($id);
        return view('auth.changepassword', ['user' => $user]);
    }

    /**
     * Store the changed password for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request.
     * @return \Illuminate\Http\RedirectResponse
     */
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
                    return back()->withErrors('message.same_as_current');
                }
                $this->authService->storeChangedPassword($request->new_password, $auth->id);
                return redirect()->route('users.index', $auth->id);
            } else {
                return back()->withErrors('message.current_incorrect');
            }
        } else {
            return back()->withErrors('message.not_authenticated');
        }
    }

    /**
     * Display the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function forgotpassword(): View
    {
        return view('auth.forgotpassword');
    }

    /**
     * Display the password reset form.
     *
     * @param  string  $token The password reset token.
     * @return \Illuminate\View\View
     */
    public function resetPassword(string $token): View
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    /**
     * Store the reset password request.
     *
     * @param  \Illuminate\Http\Request  $request The HTTP request.
     * @return \Illuminate\Http\RedirectResponse
     */
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
