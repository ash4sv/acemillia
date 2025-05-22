<?php

namespace App\Models\Admin\Service;

use App\Models\Order\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentItem extends Model
{
    use SoftDeletes;

    protected $table = 'shipment_items';

    protected $fillable = [
        'shipment_id',
        'order_item_id',
        'quantity',
    ];

    protected $guarded = [];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }
}
