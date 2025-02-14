<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOptionValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_option_values';

    protected $fillable = [
        'merchant_id', 'product_id', 'product_option_id', 'value', 'additional_price', 'image_path', 'stock'
    ];

    protected $guarded = [
        'merchant_id', 'product_id', 'product_option_id', 'value', 'additional_price', 'image_path', 'stock'
    ];

    protected function option()
    {
        return $this->belongsTo(ProductOption::class);
    }
}
