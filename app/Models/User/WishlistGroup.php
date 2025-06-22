<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishlistGroup extends Model
{
    use SoftDeletes;

    protected $table = 'wishlist_groups';

    protected $fillable = [
        'wishlist_id',
        'name',
        'slug',
    ];

    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class, 'wishlist_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class, 'wishlist_group_id', 'id');
    }
}
