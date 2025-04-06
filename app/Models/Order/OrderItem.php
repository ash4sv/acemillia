<?php

namespace App\Models\Order;

use App\Models\Shop\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use SoftDeletes;

    protected $table = 'order_items';

    protected $fillable = [
        'sub_order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'options',
    ];

    public function subOrder()
    {
        return $this->belongsTo(SubOrder::class, 'sub_order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
