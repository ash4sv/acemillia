<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishlistItem extends Model
{
    use SoftDeletes;

    protected $table = 'wishlist_items';

    protected $fillable = [
        'wishlist_group_id',
        'product_id',
        'name',
        'slug',
        'description',
        'url',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(WishlistGroup::class, 'wishlist_group_id', 'id');
    }
}
