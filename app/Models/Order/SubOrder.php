<?php

namespace App\Models\Order;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubOrder extends Model
{
    use SoftDeletes;

    protected $table = 'sub_orders';

    protected $fillable = [
        'order_id',
        'merchant_id',
        'subtotal',
        'subtotal_with_commission',
        'commission_amount',
        'shipping_status',
        'tracking_number',
        'notes',
    ];

    public function getSubTotalAttribute($value)
    {
        return 'RM' . number_format($value, 2);
    }

    public function totalWeightValue(): float
    {
        return $this->items()
            ->with('product:id,weight')
            ->get()
            ->sum(fn($item) => ($item->quantity ?? 0) * ($item->product->weight ?? 0));
    }

    public function totalWeight(): string
    {
        return number_format($this->totalWeightValue(), 2);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'sub_order_id', 'id');
    }

    public function shippingLogs()
    {
        return $this->hasMany(ShippingStatusLog::class, 'sub_order_id', 'id');
    }
}
