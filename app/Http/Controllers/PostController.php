<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PostServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Posts;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PostController extends Controller
{
    protected $postService;
    protected $userService;
    protected $commentService; 

    /**
     * Create a new PostController instance.
     *
     * @param  \App\Contracts\Services\PostServiceInterface  $postService  The service responsible for handling posts.
     * @param  \App\Contracts\Services\UserServiceInterface  $userService  The service responsible for handling users.
     */
    public function __construct(PostServiceInterface $postService, UserServiceInterface $userService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
    }

    /**
     * Display the form for creating a new post.
     *
     * @return mixed
     */
    public function create(): mixed
    {
        return view('posts.create', ['user_id' => Auth::user()->id]);
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request  The HTTP request containing post data.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $postId = $this->postService->insert($request);

        return redirect()->route('posts.postindex', [$postId])->with('success', 'Post created successfully');
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $posts = $this->postService->getAllPost();
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Display the authenticated user's details and posts.
     *
     * @return \Illuminate\View\View
     */
    public function showUserDetail(): View
    {
        $user = auth()->user(); // Retrieve authenticated user
        $posts = Posts::all(); // Fetch all posts (replace this with your actual query)

        return view('users.detail', compact('user', 'posts'));
    }

    /**
     * Display the specified post.
     *
     * @param  int  $id  The ID of the post to display.
     * @return \Illuminate\View\View
     */
    public function show(int $id): View
    {
        $post = $this->postService->getPostById($id);
        return view('posts.post', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id  The ID of the post to edit.
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        $post = $this->postService->getPostById($id);
        return view('posts.edit', ['post' => $post, 'updated_by' => Auth::user()->id]);
    }

    /**
     * Update the specified post in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request  The HTTP request containing updated post data.
     * @param  \App\Models\Post  $post  The post instance to update.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePostRequest $request, Posts $post): RedirectResponse
    {
        $this->postService->update($request);
        return redirect()->route('users.showdetail')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  int  $id  The ID of the post to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->postService->delete($id);
        return redirect()->route('users.showdetail')->with('success', 'Post deleted successfully.');
    }

    /**
     * Show the form for displaying user details and posts.
     *
     * @return \Illuminate\View\View
     */
    public function showDetailForm(): View
    {
        $user = Auth::user();
        $posts = Posts::all(); // Assuming you have a Post model

        return view('posts.index', compact('user', 'posts'));
    }
}
