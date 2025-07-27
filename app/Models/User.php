<?php

namespace App\Models;

use App\Models\Order\Order;
use App\Models\Social\NewsFeed;
use App\Models\Social\NewsFeedComment;
use App\Models\Social\NewsFeedLike;
use App\Models\User\AddressBook;
use App\Notifications\User\UserEmailVerificationNotification;
use App\Notifications\User\UserResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'phone',
        'icon_avatar',
        'img_avatar',
        'gender',
        'date_of_birth',
        'nationality',
        'identification_number',
        'upload_documents',
        'status_submission',
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

    public function sendUserEmailVerificationNotification()
    {
        $this->notify(new UserEmailVerificationNotification());
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function addressBooks()
    {
        return $this->hasMany(AddressBook::class, 'user_id', 'id');
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

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}
