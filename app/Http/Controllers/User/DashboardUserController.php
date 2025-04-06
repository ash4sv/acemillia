<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    protected $authUser;

    public function __construct()
    {
        $this->authUser = auth()->guard('web')->user();
    }

    public function index(Request $request)
    {
        return response()->view('apps.user.dashboard.index', [
            'authUser' => $this->authUser
        ]);
    }

    public function notifications(Request $request)
    {
        return response()->view('apps.user.notifications.index', [
            'authUser' => $this->authUser
        ]);
    }

    public function myOrders()
    {
        $orders = Order::with([
            'subOrders.merchant',
            'subOrders.items',
            'payment',
            'billingAddress',
            'shippingAddress',
        ])->auth()
            ->paginate(12)
            ->appends(['section' => 'my-order']);
        return response()->view('apps.user.my-orders.index', [
            'authUser' => $this->authUser,
            'orders'   => $orders,
        ]);
    }

    public function myOrderShow(Request $request)
    {
        $orderId = $request->query('id');

        $order = Order::with([
            'subOrders.merchant',
            'subOrders.items',
            'payment',
            'billingAddress',
            'shippingAddress',
        ])->auth()->findOrFail($orderId);

        return response()->view('apps.user.my-orders.show', [
            'authUser' => $this->authUser,
            'order'    => $order,
        ]);
    }
}
