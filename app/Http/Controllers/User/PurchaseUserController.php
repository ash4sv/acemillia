<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductOption;
use App\Models\Shop\ProductOptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\Cart\Facades\Cart;
use RealRashid\SweetAlert\Facades\Alert;
use Billplz\Client;

class PurchaseUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updateOrCreateCart(Request $request)
    {
        // 1. Validate incoming data
        $request->validate([
            'product'    => 'required|integer',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required', // final price provided from the form
            'base-price' => 'required', // provided base price (if needed)
            'options'    => 'required|array'
        ]);

        // 2. Retrieve product from DB
        $product = Product::findOrFail($request->product);
        $finalPrice = (float) $request->input('price'); // final price from form
        // $basePrice = (float) $request->input('base-price'); // available if needed

        // 3. Build the selected_options array from submitted options.
        //    The request "options" is expected to be an associative array like:
        //    {"1": {"option": "9", "value": "17"}, "0": {"option": "5", "value": "26"}}
        $selectedOptions = [];
        foreach ($request->options as $key => $opt) {
            $optionModel = ProductOption::findOrFail($opt['option']);
            $valueModel  = ProductOptionValue::findOrFail($opt['value']);

            $selectedOptions[] = [
                'option_id'        => (int) $optionModel->id,
                'option_name'      => $optionModel->name,
                'value_id'         => (int) $valueModel->id,
                'value_name'       => $valueModel->value,
                'additional_price' => (float) ($valueModel->additional_price ?? 0)
            ];
        }

        // 4. Compute the options hash and composite row id.
        $hash = $this->getOptionsHash($selectedOptions);
        $rowId = $product->id . '-' . $hash;

        // 5. Prepare the options array for the cart item.
        //    Adjust "item_menu" as needed (here we use a placeholder).
        $cartOptions = [
            'item_menu'        => $product->categories->first()->menus->pluck('name')->implode(', ') ?? '', // or derive from $product if applicable
            'item_category'    => $product->categories->pluck('name')->implode(', ') ?? '',
            'item_img'         => $product->image,
            'item_product_id'  => $product->id,
            'merchant_id'      => $product->merchant_id,
            'selected_options' => $selectedOptions,
        ];

        // 6. Determine the quantity from the request.
        $quantity = (int) $request->input('quantity');

        // 7. Check if the cart already contains an item with this composite row id.
        $existingItem = Cart::get($rowId);
        if ($existingItem) {
            // Update the quantity: add new quantity to the existing one.
            $newQuantity = $existingItem->getQuantity() + $quantity;
            Cart::updateQuantity($rowId, $newQuantity);
            Cart::updateDetails($rowId, [
                'name'  => $product->name,
                'price' => $finalPrice
            ]);
            Cart::updateOptions($rowId, $cartOptions);
        } else {
            // Add a new cart item with the composite row id.
            Cart::add(
                $rowId,
                $product->name,
                $quantity,
                $finalPrice,
                $cartOptions
            );
        }

        Alert::success('Success', 'Product added to cart.');
        return back();
    }

    public function updateCartQuantity(Request $request)
    {
        // Get the cart item ID and the new quantity from the request.
        $id = $request->input('id');
        $newQuantity = (int)$request->input('quantity');

        // Update the quantity in the cart; using 'replace' sets it to the given quantity.
        Cart::updateQuantity($id, $newQuantity);

        // Retrieve the updated cart item.
        $item = Cart::get($id);

        // Calculate the new total for the item.
        $itemTotal = $item->getQuantity() * $item->getPrice();

        // Get the new cart subtotal.
        // (Assuming Cart::subtotal() returns a numeric or numeric-like value.)
        $cartSubtotal = Cart::subtotal();

        return response()->json([
            'success' => true,
            'quantity' => $item->getQuantity(),
            'item_total' => $itemTotal,
            'cart_subtotal' => $cartSubtotal,
        ]);
    }


    /**
     * Helper function to compute a canonical hash from an array of selected options.
     */
    private function getOptionsHash(array $options)
    {
        // Sort the options by option_id then value_id to normalize order.
        usort($options, function ($a, $b) {
            if ($a['option_id'] === $b['option_id']) {
                return $a['value_id'] <=> $b['value_id'];
            }
            return $a['option_id'] <=> $b['option_id'];
        });

        // Build a hash string (e.g., "5:26-9:17")
        $hashParts = [];
        foreach ($options as $opt) {
            $hashParts[] = $opt['option_id'] . ':' . $opt['value_id'];
        }
        return implode('-', $hashParts);
    }

    public function options(string $id)
    {
        $existingItem = Cart::get($id);
        return response()->view('apps.user.purchase.options', [
            'existingItem' => $existingItem
        ]);
    }

    public function removeFromCart(string $id)
    {
        Cart::remove($id);
        Alert::success('Success', 'Booths removed from cart successfully.');
        return back();
    }

    public function removeOptionGroup($productId, $groupKey)
    {
        // Retrieve the cart item using the product ID.
        $existingItem = Cart::get($productId);
        if (!$existingItem) {
            Alert::error('Error', 'Product not found in cart.');
            return back();
        }

        // If Cart::get returns an array, use the first CartItem.
        if (is_array($existingItem)) {
            $existingItem = reset($existingItem);
        }

        // Retrieve current options and option groups.
        $options = $existingItem->getOptions();
        $optionGroups = isset($options['option_groups']) ? $options['option_groups'] : [];

        // Validate that the provided group key exists.
        if (!isset($optionGroups[$groupKey])) {
            Alert::error('Error', 'Option group not found.');
            return back();
        }

        // Remove the option group at the specified key.
        unset($optionGroups[$groupKey]);
        // Re-index the array so that keys are reset.
        $optionGroups = array_values($optionGroups);

        // Recalculate the overall quantity from the remaining groups.
        $overallQuantity = 0;
        foreach ($optionGroups as $group) {
            $overallQuantity += $group['quantity'];
        }

        if ($overallQuantity <= 0) {
            // If no option groups remain, remove the entire product from the cart.
            Cart::remove($productId);
            Alert::success('Success', 'Product removed from cart.');
        } else {
            // Otherwise, update the cart item options and overall quantity.
            $options['option_groups'] = $optionGroups;
            Cart::updateOptions($productId, $options);
            Cart::updateQuantity($productId, $overallQuantity);
            Alert::success('Success', 'Option group removed from cart.');
        }

        return back();
    }

    public function clearCart(Request $request)
    {
        Cart::removeCoupon();
        Cart::clear();
        Alert::success('Success', 'Your cart cleared successfully.');
        return back();
    }

    public function viewCart()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Cart'],
        ]);
        return response()->view('apps.user.purchase.cart', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function checkout()
    {
        $breadcrumbs = array_merge($this->breadcrumbs, [
            ['label' => 'Checkout'],
        ]);

        $temporaryUniqid = sprintf("%06d", mt_rand(1, 999999));
        return response()->view('apps.user.purchase.checkout', [
            'temporaryUniqid' => $temporaryUniqid,
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function checkoutPost(Request $request)
    {
        $validated = $request->validate([
            'shippingAddress' => 'required|string',
            'billingAddress'  => 'required|string',
            'uniq'            => 'required|string',
        ]);

        $user = auth()->guard('web')->user();

        if (cart()->count() > 0 && $user)
        {
            $additionalFee   = 0;
            $description     = 'User Purchase of Ticket';
            $subTotal        = cart()->subtotal();
            $total           = cart()->total();
            $priceMyr        = env('APP_ENV') === 'production' ? (100 * $total) + $additionalFee : 100;
            $mobileNumber    = preg_replace('/[^0-9]/', '', $user->phone);

            $shippingAddress = $validated['shippingAddress'];
            $billingAddress  = $validated['billingAddress'];
            $uniq            = $validated['uniq'];
            $cartData        = cart()->all();

            $mergedData = [
                'uniq'            => $uniq,
                'billingAddress'  => $billingAddress,
                'shippingAddress' => $shippingAddress,
                'cart'            => $cartData,
            ];

            $billplz = Client::make(config('billplz.billplz_key'), config('billplz.billplz_signature'));
            if(config('billplz.billplz_sandbox')) {
                $billplz->useSandbox();
            }
            $bill = $billplz->bill();
            $bill = $bill->create(
                config('billplz.billplz_collection_id'),
                $user->email,
                $mobileNumber,
                $user->name,
                \Duit\MYR::given($priceMyr),
                route('purchase.payment.webhook.url'),
                $description,
                ['redirect_url' => route('purchase.payment.redirect.url')],
            );

            DB::table('order_temps')->insert([
                'user_id'          => $user->id,
                'temporary_uniq'   => $uniq,
                'transaction_data' => json_encode($bill->toArray()),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            DB::table('carts_temps')->insert([
                'user_id'         => $user->id,
                'temporary_uniq'  => $uniq,
                'cart'            => json_encode($mergedData),
                'discount_code'   => null,
                'discount_amount' => null,
                'sub_total'       => $subTotal,
                'total'           => $total,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // cart()->removeCoupon();
            // cart()->clear();

            Log::info('CHECKOUT SUBMIT ' . date('Y-m-d H:i:s') . ' - ' . $uniq);

            return response()->json([
                'success' => true,
                'redirectUrl' => $bill->toArray()['url']
            ]);
        }
    }
}
