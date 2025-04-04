<?php

namespace App\Models;

use App\Models\Admin\Blog\Post;
use App\Models\Social\NewsFeed;
use App\Models\Social\NewsFeedComment;
use App\Models\Social\NewsFeedLike;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PharIo\Manifest\Author;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'admin_id', 'id');
    }

    public function newsfeeds()
    {
        return $this->morphMany(NewsFeed::class, 'newsfeedable', 'model_type', 'model_id');
    }

    public function newsfeedLikes()
    {
        return $this->morphMany(NewsFeedLike::class, 'actor', 'model_type', 'model_id');
    }

    public function newsfeedComments()
    {
        return $this->morphMany(NewsFeedComment::class, 'actor', 'model_type', 'model_id');
    }
}
