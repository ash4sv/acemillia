<?php

namespace App\Models\Admin\Service;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;

    protected $table = 'shipments';

    protected $fillable = [
        'order_id',
        'courier_id',
        'tracking_number',
        'shipment_status',
        'awb_url',
        'pickup_date',
        'delivery_date',
    ];

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function shipmentItems()
    {
        return $this->hasMany(ShipmentItem::class, 'shipment_id', 'id');
    }
}
