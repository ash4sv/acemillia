<?php

namespace App\Models\Order;

use App\Models\Merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingStatusLog extends Model
{
    use SoftDeletes;

    protected $table = 'shipping_status_logs';

    protected $fillable = [
        'sub_order_id',
        'status',
        'notes',
        'created_by',
        'tracking_number',
        'courier_name',
        'expected_delivery',
    ];

    public function subOrder()
    {
        return $this->belongsTo(SubOrder::class, 'sub_order_id', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'created_by', 'id');
    }
}
