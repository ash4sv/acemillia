<?php

namespace App\Models\Order;

use App\Models\User;
use App\Models\User\AddressBook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'uniq',
        'order_number',
        'cart_temp_id',
        'total_amount',
        'payment_status',
        'status',
        'billing_address_id',
        'shipping_address_id',
    ];

    public function getTotalAmountAttribute($value)
    {
        return 'RM' . number_format($value, 2);
    }

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

    public function scopeAuth($query)
    {
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
        } elseif (Auth::guard('merchant')->check()) {
            $user = Auth::guard('merchant')->user();
        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        }
        return $query->where('user_id', $user->id);
    }

    public static function generateOrderReference(): array
    {
        $lastUniqueValue = DB::table('orders')
            ->whereNotNull('uniq')
            ->where('uniq', '!=', '')
            ->orderBy('uniq', 'desc')
            ->value('uniq');

        $lastNumber = $lastUniqueValue && is_numeric($lastUniqueValue)
            ? intval(substr($lastUniqueValue, -8))
            : 0;

        $newNumber = str_pad($lastNumber + 1, 8, '0', STR_PAD_LEFT);
        $randomString = collect(range('A', 'Z'))->shuffle()->take(5)->implode('');
        $orderNumber = now()->format('Ymd') . $randomString . $newNumber;

        return [
            'uniq' => $newNumber,
            'order_number' => $orderNumber
        ];
    }
}
