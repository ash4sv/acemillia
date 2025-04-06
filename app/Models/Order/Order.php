<?php

namespace App\Models\Order;

use App\Models\User;
use App\Models\User\AddressBook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'uniq',
        'cart_temp_id',
        'total_amount',
        'payment_status',
        'status',
        'billing_address_id',
        'shipping_address_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class, 'order_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(AddressBook::class, 'billing_address_id', 'id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(AddressBook::class, 'shipping_address_id', 'id');
    }
}
