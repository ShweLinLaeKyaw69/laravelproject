<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['posts_id', 'user_id', 'comment'];

    /**
     * Check if user can edit the comment
     *
     * @return boolean
     */
    public function getCanEditAttribute(): bool
    {
        return Auth::check() ? (Auth::user()->id == $this->user_id) : false;
    }

    /**
     * Laravel relationship: Comment Belongs to User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Laravel relationship: Comment Belongs to Post
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Posts::class);
    }
}
