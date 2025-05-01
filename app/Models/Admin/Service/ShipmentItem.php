<?php

namespace App\Models\Admin\Service;

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
}
