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
        $user = Auth::user();
        $posts = Posts::all(); 
        return $posts;
        return view('users.detail', compact('user', 'posts'));
    }

     /**
     * get public posts
     *
     * @return collection
     */
    public function getPublicPost(): collection
    {
        $userIds = User::select('id')->get()->pluck('id');
        $posts = Posts::with('comments')->whereIn('created_by', $userIds)->where('public_flag', true)->orderBy('updated_at')->get();

        return $posts;
    }

     /**
     * Get post by id
     *
     * @param integer $postId
     * @return Post
     */
    public function getPostById(int $postId): Posts
    {
        return Posts::with(['comments', 'comments.user'])->where('id', $postId)->first();
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
     * Import csv file
     *
     * @param CsvUploadRequest $request
     * @return boolean
     */
    public function csvImport(CsvUploadRequest $request): bool
    {
        DB::beginTransaction();
        $import = new PostsImport();
        $import->import($request->file('posts_csv'));
        $failures = $import->failures();
        if (count($failures) > 0) {
            DB::rollBack();
            return false;
        } else {
            DB::commit();
            return true;
        }
    }
}
