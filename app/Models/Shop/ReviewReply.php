<?php

namespace App\Models\Shop;

use App\Enums\ReplyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    protected $table = 'review_replies';

    protected $fillable = [
        'review_id',
        'user_id',
        'reply',
        'reply_type',
    ];

    protected $guarded = [];

    protected $casts = [
        'reply_type' => ReplyType::class,
    ];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
