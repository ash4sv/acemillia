<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsFeedLike extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'newsfeed_likes';

    protected $fillable = [
        'newsfeed_id',
        'model_id',
        'model_type'
    ];

    public function actor()
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }

    public function newsfeed()
    {
        return $this->belongsTo(NewsFeed::class, 'newsfeed_id', 'id');
    }
}
