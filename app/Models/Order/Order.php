<?php

namespace App\Models\Order;

use App\Models\Admin\Service\Shipment;
use App\Models\User;
use App\Models\User\AddressBook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        'admin_commission',
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

    public function shipment()
    {
        return $this->hasMany(Shipment::class, 'order_id', 'id');
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

    /**
     * Merchandise subtotal = sum of (price × quantity) over all OrderItems.
     */
    public function getMerchandiseSubtotalAttribute(): float
    {
        return $this->subOrders
            ->flatMap->items
            ->sum(fn($item) => $item->price * $item->quantity);
    }

    /**
     * Build the five timeline events in order:
     * 1. Order Placed
     * 2. Order Paid
     * 3. Shipped Out (one line per SubOrder)
     * 4. Order Received (once all shipments delivered)
     * 5. Order Completed
     *
     * @return array
     */
    public function getTimelineEventsAttribute(): array
    {
        $events = collect();

        //
        // 1. Order Placed
        //
        $placedDate  = $this->created_at;
        $placedClass = null; // always “complete” once created
        $events->push([
            'class'   => $placedClass,
            'label'   => 'Order Placed',
            'date'    => $placedDate,
            'icon'    => 'fas fa-cart-plus',
            'details' => [],
        ]);

        //
        // 2. Order Paid / Pending
        //
        $paidDate  = optional($this->payment)->paid_at;
        $paidClass = $paidDate ? null : 'in-progress';
        $events->push([
            'class'   => $paidClass,
            'label'   => $paidDate ? 'Order Paid' : 'Payment Pending',
            'date'    => $paidDate,
            'icon'    => 'fas fa-credit-card',
            'details' => [],
        ]);

        //
        // 3. Shipped Out / Pending
        //
        $subs        = $this->subOrders ?? collect();
        $totalSubs   = $subs->count();
        $shippedSubs = $subs->where('shipping_status', 'shipped')->count();

        if ($totalSubs === 0) {
            $shipLabel = 'No Shipments';
            $shipDate  = null;
            $lines     = [];
        } else {
            if ($shippedSubs === 0) {
                $shipLabel = 'Pending Shipment';
            } elseif ($shippedSubs < $totalSubs) {
                $shipLabel = "Partially Shipped Out ({$shippedSubs}/{$totalSubs})";
            } else {
                $shipLabel = 'Shipped Out';
            }

            $dates    = $subs->pluck('updated_at')->filter();
            $shipDate = $dates->isEmpty() ? null : $dates->min();

            $lines = $subs
                ->flatMap(fn($sub) => $sub->items)    // collect all OrderItems
                ->map(fn($item) =>
                    Str::limit($item->product_name, 15, '')
                    . ': '
                    . ucfirst($sub->shipping_status ?? 'pending')
                )
                ->all();
        }

        $shipClass = $shipLabel === 'Shipped Out' ? null : 'in-progress';
        $events->push([
            'class'   => $shipClass,
            'label'   => $shipLabel,
            'date'    => $shipDate,
            'icon'    => 'fas fa-truck',
            'details' => $lines,
        ]);

        //
        // 4. Order Received / Awaiting Delivery
        //
        $shipments = $this->shipments ?? collect();
        $delivered = $shipments->where('status', 'delivered');
        $delCount  = $delivered->count();

        if ($totalSubs === 0) {
            $recvLabel = 'No Delivery';
            $recvDate  = null;
        } elseif ($delCount === 0) {
            $recvLabel = 'Awaiting Delivery';
            $recvDate  = null;
        } elseif ($delCount < $totalSubs) {
            $recvLabel = "Partial Received ({$delCount}/{$totalSubs})";
            $recvDate  = $delivered->pluck('updated_at')->filter()->min() ?: null;
        } else {
            $recvLabel = 'Order Received';
            $recvDate  = $delivered->pluck('updated_at')->filter()->max() ?: null;
        }

        $recvClass = $recvLabel === 'Order Received' ? null : 'in-progress';
        $events->push([
            'class'   => $recvClass,
            'label'   => $recvLabel,
            'date'    => $recvDate,
            'icon'    => 'fas fa-box-open',
            'details' => [],
        ]);

        //
        // 5. Order Completed / Incomplete
        //
        $isComplete = $this->status === 'completed';
        $compDate   = $isComplete ? $this->updated_at : null;
        $compClass  = $isComplete ? null : 'in-progress';

        $events->push([
            'class'   => $compClass,
            'label'   => $isComplete ? 'Order Completed' : 'Order Incomplete',
            'date'    => $compDate,
            'icon'    => 'fas fa-check',
            'details' => [],
        ]);

        // return in fixed sequence
        return $events->values()->all();
    }

    /**
     * Shipping fee = sum of each Shipment's courier rate.
     */
    public function getShippingFeeAttribute(): float
    {
        // Make sure we always have a Collection
        $shipments = $this->shipments ?? collect();

        // Your fallback default (set in config/shipping.php as ['default_rate' => 0])
        $defaultRate = config('shipping.default_rate', 0);

        // If there are no shipments at all, return the default
        if ($shipments->isEmpty()) {
            return $defaultRate;
        }

        // Sum up each courier rate, falling back per‐shipment if needed
        return $shipments->sum(fn($shipment) => optional($shipment->courier)->rate ?? $defaultRate);
    }
}
