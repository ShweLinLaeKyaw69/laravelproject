<?php
namespace App\Dao;

use App\Contracts\Dao\PostDaoInterface;
use App\Http\Requests\CsvUploadRequest;
use App\Imports\PostsImport;
use Illuminate\Support\Collection;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostDao implements PostDaoInterface
{
    /**
     * Create new post
     *
     * @param array $insertData
     * @return integer
     */
    public function insert(array $insertData): int
    {
        $post = Posts::create($insertData);
        return $post->id;
    }

    
    /**
     * Get all posts
     *
     * @return Collection
     */
    public function getAllPost(): Collection
    {
        $posts = Posts::all(); 
        return $posts;
    }

     /**
     * get public posts
     *
     * @return collection
     */
    public function getPublicPost(): collection
    {
        $userIds = User::select('id')->get()->pluck('id');
        $posts = Posts::with('comments')->where('public_flag', true)->orderBy('updated_at')->get();

        return $posts;
    }
     /**
     * Get post by id
     *
     * @param integer $postId
     * @return Post
     */
    public function getPostById(int $post_id): Posts
    {
        return Posts::with('user')->findOrFail($post_id);
    }
    /**
     * Check if post exists
     *
     * @param Request $request
     * @return boolean
     */
    public function verifyPostExists(Request $request): bool
    {
        return Posts::findOrFail($request->id) ? true : false;
    }
    
     /**
     * Update post in database
     *
     * @param array $updateData
     * @param integer $postId
     * @return void
     */
    public function update(array $updateData, int $postId): void
    {
        Posts::where('id', $postId)->update($updateData);
    }
    
      /**
     * Delete post
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Posts::where('id', $id)->delete();
    }

    /**
     * Display the authenticated user's details and posts.
     *
     * @return \Illuminate\View\View
     */
    public function showUserDetail()
    {
        $user = auth()->user(); 
        $posts = Posts::all(); 

        return $posts;
    }
}
