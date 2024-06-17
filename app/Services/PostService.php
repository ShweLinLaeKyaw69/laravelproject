<?php

namespace App\Services;

use App\Contracts\Dao\PostDaoInterface;
use App\Contracts\Services\PostServiceInterface;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class PostService implements PostServiceInterface
{
    protected $postDao;

    /**
     * Constructor for PostService class.
     *
     * @param PostDaoInterface $postDao The data access object for posts.
     */
    public function __construct(PostDaoInterface $postDao)
    {
        $this->postDao = $postDao;
    }


    /**
     * Insert a new post.
     *
     * @param StorePostRequest $request
     * @return int
     */
    public function insert(StorePostRequest $request): int
    {
        $insertData = [
            'title' => $request->title,
            'description' => $request->description,
            'public_flag' => $request->has('public_flag'), // This will automatically evaluate to true or false
            'user_id' => Auth::id()
        ];
        return $this->postDao->insert($insertData);
    }

    /**
     * Get all posts.
     *
     * @return Collection
     */
    public function getAllPost(): Collection
    {
        if (Auth::check()) {
            $posts = $this->postDao->getAllPost();
        } else {
            $posts = $this->postDao->getPublicPost();
        }
        return $posts;
    }

    /**
     * Get a post by its ID.
     *
     * @param int $post_id
     * @return Posts
     */
    public function getPostById(int $post_id): Posts
    {
        return Posts::with('user')->findOrFail($post_id);
    }

    /**
     * Verify if a post exists.
     *
     * @param Request $request
     * @return bool
     */
    public function verifyPostExists(Request $request): bool
    {
        return $this->postDao->verifyPostExists($request);
    }

    /**
     * Update a post.
     *
     * @param UpdatePostRequest $request
     * @return void
     */
    public function update(UpdatePostRequest $request): void
    {
        $post_id = $request->id;
        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'public_flag' => $request->has('public_flag') ? true : false,
            'user_id' => $request->user_id,
            'updated_by' => $request->updated_by
        ];

        $this->postDao->update($updateData, $post_id);
    }

    /**
     * Delete a post.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->postDao->delete($id);
    }
}
