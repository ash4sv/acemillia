<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use App\Models\Shop\ProductOption;
use App\Models\Shop\ProductOptionValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\Cart\Facades\Cart;
use RealRashid\SweetAlert\Facades\Alert;

class PurchaseUserController extends Controller
{
    public function updateOrCreateCart(Request $request)
    {
        // 1. Validate incoming data
        $request->validate([
            'product'  => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price'    => 'required',
            'options'  => 'array'
        ]);

        // 2. Retrieve product from DB
        $product = Product::findOrFail($request->product);

        // 3. Clean up the price by removing all non-numeric characters (except the decimal point)
        $rawPrice   = $request->input('price');
        $cleanPrice = (float) preg_replace('/[^0-9.]/', '', $rawPrice);

        // 4. Build the new option group from the submitted options (flat array)
        $newOptions = [];
        if ($request->has('options')) {
            foreach ($request->options as $opt) {
                $optionModel = ProductOption::findOrFail($opt['option']);
                $valueModel  = ProductOptionValue::findOrFail($opt['value']);

                $newOptions[] = [
                    'option_id'   => $optionModel->id,
                    'option_name' => $optionModel->name,
                    'value_id'    => $valueModel->id,
                    'value_name'  => $valueModel->value,
                ];
            }
        }

        // Create the new group with its own quantity
        $newGroup = [
            'options'  => $newOptions,
            'quantity' => (int) $request->input('quantity'),
        ];

        // 5. Prepare the attributes array (we use "option_groups" for grouping options)
        $attributes = [
            'item_category' => $product->categories->pluck('name')->implode(', ') ?? '',
            'item_img'      => $product->image,
            'option_groups' => [], // to be set or merged later
        ];

        // 6. Check if this product already exists in the cart
        $existingItem = Cart::get($product->id);
        if ($existingItem) {
            // In case Cart::get() returns an array, pick the first CartItem
            if (is_array($existingItem)) {
                $existingItem = reset($existingItem);
            }

            // Retrieve any existing option groups
            $existingGroups = $existingItem->getOptions()['option_groups'] ?? [];

            // Create a hash for the new options (for comparison)
            $newGroupHash = $this->getOptionsHash($newOptions);
            $found = false;

            // Loop through the existing groups to see if one matches the new group
            foreach ($existingGroups as &$group) {
                $groupHash = $this->getOptionsHash($group['options']);
                if ($groupHash === $newGroupHash) {
                    // Matching option group found: update its quantity
                    $group['quantity'] += (int) $request->input('quantity');
                    $found = true;
                    break;
                }
            }
            unset($group);

            // If no matching group is found, add the new group
            if (!$found) {
                $existingGroups[] = $newGroup;
            }

            // Calculate the overall quantity as the sum of all group quantities
            $overallQuantity = 0;
            foreach ($existingGroups as $group) {
                $overallQuantity += $group['quantity'];
            }

            // Update the cart item details, overall quantity, and options with the merged groups
            Cart::updateDetails($product->id, [
                'name'  => $product->name,
                'price' => $cleanPrice,
            ]);
            Cart::updateQuantity($product->id, $overallQuantity);
            Cart::updateOptions($product->id, [
                'item_category' => $attributes['item_category'],
                'item_img'      => $attributes['item_img'],
                'option_groups' => $existingGroups,
            ]);
        } else {
            // Product is not yet in the cart. Add it with the new option group.
            $attributes['option_groups'][] = $newGroup;
            Cart::add(
                $product->id,
                $product->name,
                (int)$request->input('quantity'),
                $cleanPrice,
                $attributes
            );
        }

        Alert::success('Success add to cart!', 'Item added or updated in the cart.');
        return redirect()->back();
    }

    private function getOptionsHash(array $options)
    {
        // Sort the options by option_id then value_id to normalize order.
        usort($options, function($a, $b) {
            if ($a['option_id'] === $b['option_id']) {
                return $a['value_id'] <=> $b['value_id'];
            }
            return $a['option_id'] <=> $b['option_id'];
        });

        // Build a hash string (e.g., "5:13-9:17")
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
        return redirect()->back();
    }

    public function clearCart(Request $request)
    {
        Cart::removeCoupon();
        Cart::clear();
        Alert::success('Success', 'Your cart cleared successfully.');
        return redirect()->back();
    }

    public function viewCart()
    {
        return response()->view('apps.user.purchase.cart');
    }

    public function checkout()
    {
        $temporaryUniqid   = sprintf("%06d", mt_rand(1, 999999));
    }

    public function checkoutPost(Request $request)
    {
        if (cart()->count() > 0)
        {

        }
    }
}
