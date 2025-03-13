<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Billplz\Client;

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

                if ($updateCartData->user == 'user') {
                    Log::info('PAYMENT REDIRECT FUNCTION END: SUCCESS TRUE ' . $id . ' ' . date('Ymd/m/y H:i'));
                    return response()->view($this->view . 'success');
                }
            } elseif ($bill['data']['paid'] == 'false') {
                Log::info('PAYMENT REDIRECT FUNCTION END: FALSE ' . $bill['data']['id']  . ' ' . date('Ymd/m/y H:i'));
                return response()->view($this->view . 'failed');
            } else {
                $id = $bill['data']['id'];
                $whatUser = DB::table('order_temps')->whereJsonContains('transaction_data->id', $id)->first();

                Log::error(['RESPONSE ERROR' => $response]);
                Log::info('PAYMENT REDIRECT UNSUCCESSFULLY FUNCTION END: ERROR');
                if ($whatUser->user == 'user') {
                    return response()->view($this->view . 'failed');
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


        Log::info('Queueing Payment Webhook for processing end.' . date('Ymd/m/y H:i'));
    }
}
