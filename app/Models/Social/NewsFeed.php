<?php

namespace App\Models\Social;

use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsFeed extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'newsfeeds';

    protected $fillable = [
        'text',
        'status',
        'privacy',
        'model_type',
        'model_id',
    ];

    protected $guarded = [
        'text',
        'status',
        'privacy',
        'model_type',
        'model_id',
    ];

    public function scopeDraft($query)
    {
        return QueryScopes::scopeDraft($query);
    }

    public function scopeActive($query)
    {
        return QueryScopes::scopeActive($query);
    }

    public function scopeInactive($query)
    {
        return QueryScopes::scopeInactive($query);
    }

    public function scopePublic($query)
    {
        return $query->where('privacy', 'public');
    }

    public function scopePrivate($query)
    {
        return $query->where('privacy', 'private');
    }

    public function scopeFriends($query)
    {
        return $query->where('privacy', 'friends');
    }

    public function getShortCreatedAtAttribute()
    {
        $hours = round($this->created_at->diffInRealHours());
        if ($hours > 0) {
            return $hours . 'hr';
        }
        return round($this->created_at->diffInRealMinutes()) . 'min';
    }

    public function newsfeedable()
    {
        return $this->morphTo(null, 'model_type', 'model_id');
    }

    public function likes()
    {
        return $this->hasMany(NewsFeedLike::class, 'newsfeed_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(NewsFeedComment::class, 'newsfeed_id', 'id')
                    ->whereNull('parent_id')
                    ->orderBy('created_at', 'desc');
    }
}
