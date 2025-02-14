<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use SoftDeletes;

    protected $table = 'product_images';

    protected $fillable = [
        'merchant_id', 'product_id', 'image_path',
    ];

    protected $guarded = [
        'merchant_id', 'product_id', 'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
