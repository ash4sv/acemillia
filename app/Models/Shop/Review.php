<?php

namespace App\Models\Shop;

use App\Enums\ReviewApprovalStatus;
use App\Enums\ReviewVisibilityType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review',
        'visibility_type',
        'approval_status',
    ];

    protected $guarded = [];

    protected $casts = [
        'approval_status' => ReviewApprovalStatus::class,
        'visibility_type' => ReviewVisibilityType::class,
    ];

    public function scopePublic($query)
    {
        return $query->where('visibility_type', ReviewVisibilityType::PUBLIC);
    }

    public function scopeAnonymous($query)
    {
        return $query->where('visibility_type', ReviewVisibilityType::ANONYMOUS);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', ReviewApprovalStatus::APPROVED);
    }

    public function scopeRejected($query)
    {
        return $query->where('approval_status', ReviewApprovalStatus::REJECTED);
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', ReviewApprovalStatus::PENDING);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(ReviewReply::class, 'review_id', 'id');
    }
}
