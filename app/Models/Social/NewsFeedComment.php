<?php

namespace App\Models\Social;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsFeedComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'newsfeed_comments';

    protected $fillable = [
        'newsfeed_id',
        'model_id',
        'model_type',
        'comment',
        'parent_id'
    ];

    public function actor()
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }

    public function newsfeed()
    {
        return $this->belongsTo(NewsFeed::class, 'newsfeed_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(NewsFeedComment::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(NewsFeedComment::class, 'parent_id', 'id');
    }
}
