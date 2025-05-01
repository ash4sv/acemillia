<?php

namespace App\Models\Admin\Service;

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
}
