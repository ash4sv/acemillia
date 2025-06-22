<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Wishlist extends Model
{
    use SoftDeletes;

    protected $table = 'wishlists';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'visibility',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(WishlistGroup::class, 'wishlist_id', 'id');
    }

    public static function getForUser($userId)
    {
        $cacheKey = "wishlist:{$userId}";
        return Cache::remember($cacheKey, 60 * 60 * 48, function () use ($userId) {
            return self::with('groups.items')
                ->where('user_id', $userId)
                ->first();
        });
    }

    public static function refreshCache($userId)
    {
        $cacheKey = "wishlist:{$userId}";
        Cache::forget($cacheKey);
    }
}
