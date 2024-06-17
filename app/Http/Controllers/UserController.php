<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Posts;
use Illuminate\Http\RedirectResponse;
use App\Contracts\Services\UserServiceInterface;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    /**
     * Constructor to initialize UserController with UserServiceInterface.
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the authenticated user's posts.
     *
     * @return View
     */
    public function index(): View
    {
        $user = auth()->user();
        $posts = $user->posts;
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show detailed information of a user by ID.
     *
     * @param int $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        $user = $this->userService->getUserById($id);

        if ($user != null) {
            return view('users.detail', ['user' => $user]);
        } else {
            return redirect()->route('users.index')->with('failed', 'User Does Not Exist');
        }
    }

    /**
     * Store a newly created user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|max:255',
            'password_confirmation' => 'required|min:8|max:255',
        ]);

        $this->userService->insert($request);

        return redirect()->route('login')->with('success', 'User Created Successfully');
    }

    /**
     * Display the registration form.
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $user = $this->userService->getUserById($id);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id): mixed
    {
        $this->userService->delete($id);
        return redirect()->route('loginScreen');
    }

    /**
     * Update the specified user in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        $this->userService->update($request);

        return redirect()->route('users.index')->with('success', __('messages.user_updated_success'));
    }

    /**
     * Show the detailed view of the authenticated user.
     *
     * @return View
     */
    public function showDetailForm(): View
    {
        $user = Auth::user();
        $posts = Posts::all();

        return view('users.detail', compact('user', 'posts'));
    }
}
