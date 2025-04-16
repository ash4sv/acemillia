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
        parent::__construct();
        $this->authUser = auth()->guard('web')->user();
    }

    public function index(Request $request)
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'My Account', 'url' => route('dashboard')],
            ['label' => 'Dashboard'],
        ]);

        return response()->view('apps.user.dashboard.index', [
            'authUser' => $this->authUser,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function notifications(Request $request)
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'My Account', 'url' => route('dashboard')],
            ['label' => 'Notifications'],
        ]);

        return response()->view('apps.user.notifications.index', [
            'authUser' => $this->authUser,
            'breadcrumbs' => $breadcrumbs
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

        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'My Account', 'url' => route('dashboard')],
            ['label' => 'My Orders'],
        ]);

        return response()->view('apps.user.my-orders.index', [
            'authUser' => $this->authUser,
            'orders'   => $orders,
            'breadcrumbs' => $breadcrumbs
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

        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'My Account', 'url' => route('dashboard')],
            ['label' => 'My Order Show'],
        ]);

        return response()->view('apps.user.my-orders.show', [
            'authUser' => $this->authUser,
            'order'    => $order,
            'breadcrumbs' => $breadcrumbs
        ]);
    }
}
