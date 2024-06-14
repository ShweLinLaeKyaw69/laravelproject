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
    protected $postService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        $user = auth()->user();

        $posts = $user->posts;

        return view('posts.index', ['posts' => $posts]);
    }

    public function show(int $id): mixed
    {
        $users = $this->userService->getUserById($id);
        if ($users != null) {
            return view('users.detail', ['user' => $users]);
        } else {
            return redirect()->route('users.index')->with('failed', 'User Does Not Exist');
        }
    }


    public function store(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:8|max:255',
                'password_confirmation' => 'required|min:8|max:255'
            ]);
        } else {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:8|max:255',
                'password_confirmation' => 'required|min:8|max:255',
            ]);
        }

        $this->userService->insert($request);
        return redirect()->route('login')->with('success', 'User Created Successfully');
    }

    public function create(): View
    {
        return view('auth.register');
    }

    public function edit(int $id): View
    {
        $data = $this->userService->getUserById($id);
        return view('users.edit', ['user' => $data]);
    }

    public function destroy(int $id): mixed
    {
        $this->userService->delete($id);
        return redirect()->route('loginScreen');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if (Auth::check()) {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255'
            ]);
        } else {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
            ]);
        }
        $this->userService->update($request);
        return redirect()->route('users.index')->with('success', __('messages.user_updated_success'));;
    }
    public function showDetailForm()
    {
        $user = Auth::user();
        $posts = Posts::all();

        return view('users.detail', compact('user', 'posts'));
    }
}
