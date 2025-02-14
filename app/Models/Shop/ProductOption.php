<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_options';

    protected $fillable = [
        'merchant_id', 'product_id', 'name', 'image_path',
    ];

    protected $guarded = [
        'merchant_id', 'product_id', 'name', 'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->hasMany(ProductOptionValue::class);
    }
}
