<?php

namespace App\Models\Shop;

use App\Models\Merchant;
use App\Services\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecialOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'special_offers';

    protected $fillable = [
        'product_id', 'merchant_id', 'discount_amount',
        'start_date', 'end_date',
        'single_image', 'multiple_images',
        'status_submission', 'status',
    ];

    protected $guarded = [
        'product_id', 'merchant_id', 'discount_amount',
        'start_date', 'end_date',
        'single_image', 'multiple_images',
        'status_submission', 'status',
    ];

    protected $casts = [
        'multiple_images' => 'array',
        'start_date'      => 'date',
        'end_date'        => 'date',
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

    public function scopeApproved($query)
    {
        return $query->where('status_submission', 'approved');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
