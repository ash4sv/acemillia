<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\Payment;
use App\Models\Order\SubOrder;
use App\Models\User\AddressBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Billplz\Client;
use Illuminate\Support\Str;
use RealRashid\Cart\Facades\Cart;

class AppsPaymentController extends Controller
{
    protected string $view = 'apps.user.payment.';

    public function redirectUrl(Request $request)
    {
        Log::info('PAYMENT REDIRECT FUNCTION START ' . date('Ymd/m/y H:i'));
        $response = $request->all();

        try {

            $billplz = Client::make(config('billplz.billplz_key'), config('billplz.billplz_signature'));
            if(config('billplz.billplz_sandbox')) {
                $billplz->useSandbox();
            }
            $bill = $billplz->bill();
            try {
                $bill = $bill->redirect($response);
            } catch(\Exception $exception) {
                Log::error($exception->getMessage());
            }
            $bill['data'] = $billplz->bill()->get($bill['id'])->toArray();

            if ($bill['data']['paid'] == 'true') {
                $id = $bill['data']['id'];

                // Update the order table data
                $updateOrderData = DB::table('order_temps')->whereJsonContains('transaction_data->id', $id)
                    ->update([
                        'return_url_1'   => json_encode($response),
                        'created_at'     => now(),
                    ]);
                // Update the cart table data
                $updateOrderData = DB::table('order_temps')->whereJsonContains('transaction_data->id', $id)->first();
                $updateCartData  = DB::table('carts_temps')->where('temporary_uniq', $updateOrderData->temporary_uniq)->first();

                if ($updateCartData->user == 'user' && auth()->guard('web')->check()) {
                    Log::info('PAYMENT REDIRECT FUNCTION END: SUCCESS TRUE ' . $id . ' ' . date('Ymd/m/y H:i'));
                    $cleanup = DB::table('cart_cleanup_queue')->where('transaction_id', $id)->where('user_id', auth()->guard('web')->id())->first();
                    if ($cleanup) {
                        $itemKeys = json_decode($cleanup->item_ids, true);

                        Cart::instance('default'); // or 'user_' . auth()->id() if you use named instances
                        foreach ($itemKeys as $itemKey) {
                            try {
                                Cart::remove($itemKey);
                            } catch (\Exception $e) {
                                Log::warning("Failed to remove cart item [$itemKey]: " . $e->getMessage());
                            }
                        }

                        DB::table('cart_cleanup_queue')
                            ->where('id', $cleanup->id)
                            ->update([
                                'deleted_at' => now()
                            ]);
                    }
                    return response()->view($this->view . 'success', [
                        'transaction_id' => strtoupper($id)
                    ]);
                }
            } elseif ($bill['data']['paid'] == 'false') {
                Log::info('PAYMENT REDIRECT FUNCTION END: FALSE ' . $bill['data']['id']  . ' ' . date('Ymd/m/y H:i'));
                return response()->view($this->view . 'failed', [
                    'transaction_id' => strtoupper($bill['data']['id'])
                ]);
            } else {
                $id = $bill['data']['id'];
                $whatUser = DB::table('order_temps')->whereJsonContains('transaction_data->id', $id)->first();

                Log::error(['RESPONSE ERROR' => $response]);
                Log::info('PAYMENT REDIRECT UNSUCCESSFULLY FUNCTION END: ERROR');
                if ($whatUser->user == 'user') {
                    return response()->view($this->view . 'failed', [
                        'transaction_id' => strtoupper($id)
                    ]);
                }
            }

        } catch (\Exception $exception) {

            Log::error($exception->getMessage());
            Log::info('PAYMENT REDIRECT UNSUCCESSFULLY REDIRECT ' . date('Ymd/m/y H:i'));

        }
    }

    public function webhookUrl(Request $request)
    {
        Log::info('Queueing Payment Webhook for processing start.' . date('Ymd/m/y H:i'));

        $response = $request->all();
        Log::info('PAYMENT WEBHOOK FUNCTION START ' . date('Ymd/m/y H:i'));

        $billplzId = $response['id'];
        $orderTemp = DB::table('order_temps')->whereJsonContains('transaction_data->id', $billplzId)->first();

        DB::beginTransaction();
        try {
            // ====== //
            if ($response['paid'] == 'true') {
                // STEP 2: Convert temp data into real order
                if ($orderTemp->user == 'user') {
                    DB::transaction(function () use ($billplzId, $orderTemp, $response) {
                        $cartTemp = DB::table('carts_temps')->where('temporary_uniq', $orderTemp->temporary_uniq)->first();

                        $orderRef = Order::generateOrderReference();

                        $cart = json_decode($cartTemp->cart, true);
                        $cartItems = $cart['cart'] ?? [];

                        // Fetch the billing and shipping address from the address_books table
                        $billingAddress = AddressBook::find($cart['billingAddress']);
                        $shippingAddress = AddressBook::find($cart['shippingAddress']);

                        // 2. Create final order
                        $order = Order::create([
                            'uniq'                => $orderRef['uniq'],
                            'order_number'        => $orderRef['order_number'],
                            'user_id'             => $orderTemp->user_id,
                            'total_amount'        => $cartTemp->total,
                            'cart_temp_id'        => $cartTemp->id,
                            'payment_status'      => 'paid',
                            'status'              => 'processing',
                            'billing_address_id'  => $billingAddress ? $billingAddress->id : null,
                            'shipping_address_id' => $shippingAddress ? $shippingAddress->id : null,
                        ]);

                        // 3. Group items by merchant
                        $grouped = collect($cartItems)->groupBy(fn($item) => $item['options']['merchant_id']);

                        foreach ($grouped as $merchantId => $items) {
                            $subtotal = collect($items)->sum(function ($i) {
                                $base = $i['price'];
                                $additional = collect($i['options']['selected_options'] ?? [])
                                    ->sum('additional_price');
                                return ($base + $additional) * $i['quantity'];
                            });

                            $subOrder = SubOrder::create([
                                'order_id' => $order->id,
                                'merchant_id' => $merchantId,
                                'subtotal' => $subtotal,
                                'shipping_status' => 'pending',
                            ]);

                            foreach ($items as $item) {
                                $finalPrice = $item['price'] + collect($item['options']['selected_options'] ?? [])
                                        ->sum('additional_price');

                                OrderItem::create([
                                    'sub_order_id' => $subOrder->id,
                                    'product_id' => $item['options']['item_product_id'] ?? null,
                                    'product_name' => $item['name'],
                                    'price' => $finalPrice,
                                    'quantity' => $item['quantity'],
                                    'options' => json_encode($item['options']),
                                ]);
                            }
                        }

                        // 4. Store payment info
                        Payment::create([
                            'order_id' => $order->id,
                            'gateway' => 'billplz',
                            'reference_id' => $response['id'],
                            'paid_at' => Carbon::parse($response['paid_at']),
                            'amount' => $cartTemp->total,
                            'status' => 'paid',
                            'response_data' => json_encode($response),
                        ]);

                        DB::table('carts_temps')->where('id', $cartTemp->id)->update([
                            'uniq'           => $orderRef['uniq'],
                            'order_number'   => $orderRef['order_number'],
                            'payment_status' => true,
                            'updated_at'     => now(),
                        ]);

                        DB::table('order_temps')->where('id', $orderTemp->id)->update([
                            'uniq'           => $orderRef['uniq'],
                            'order_number'   => $orderRef['order_number'],
                            'return_url_2'   => json_encode($response),
                            'payment_status' => true,
                            'created_at'     => now(),
                        ]);

                        // 5. Save item in cart cleanup queue
                        DB::table('cart_cleanup_queue')->insert([
                            'transaction_id' => $billplzId,
                            'user_id'        => $orderTemp->user_id,
                            'item_ids'       => json_encode(array_keys($cartItems)),
                            'order_id'       => $order->id,
                            'created_at'     => now(),
                            'updated_at'     => now(),
                        ]);
                    });
                } elseif ($orderTemp->user == 'merchant') {}

                Log::info('PAYMENT WEBHOOK FUNCTION END ' . date('Ymd/m/y H:i'));
            } elseif ($response['paid'] == 'false') {
                DB::transaction(function () use ($orderTemp, $response) {
                    $cartTemp = DB::table('carts_temps')->where('temporary_uniq', $orderTemp->temporary_uniq)->first();

                    DB::table('carts_temps')->where('id', $cartTemp->id)->update([
                        'updated_at'     => now(),
                    ]);

                    DB::table('order_temps')->where('id', $orderTemp->id)->update([
                        'return_url_2'   => json_encode($response),
                        'created_at'     => now(),
                    ]);
                });
                Log::info('PAYMENT UNSUCCESSFULLY WEBHOOK ' . date('Ymd/m/y H:i'));
            } else {
                Log::info('PAYMENT UNSUCCESSFULLY WEBHOOK ' . date('Ymd/m/y H:i'));
            }
            // ====== //
            DB::commit();
            return response('OK', 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            Log::info('PAYMENT UNSUCCESSFULLY WEBHOOK ' . date('Ymd/m/y H:i'));
        }

        Log::info('Queueing Payment Webhook for processing end.' . date('Ymd/m/y H:i'));
    }
}
