<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function fetchUserCartProducts($user_id): array
    {
        $products = Cart::where('user_id', $user_id)->with('product')->get();
        return ['code' => 0, 'desc' => 'successful', 'data' => $products];
    }

    public function addProductToCart(Request $request): array
    {
        $user_id = $request['user_id'];
        $product_id = $request['product_id'];

        $item = Product::find($product_id);
        $cartItem = Cart::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->first();

        if (!$item) {
            return ['code' => 1, 'desc' => 'unsuccessful', 'msg' => 'Product not found'];
        }

        if ($item['quantity'] <= 0) {
            return ['code' => 1, 'desc' => 'unsuccessful', 'msg' => 'Out of stock'];
        }

        if ($cartItem) {
            // If the item is already in the cart, increment the cart item's quantity
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // If the item is not in the cart, create a new cart item
            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => 1,
            ]);
        }

        // Decrement the product's quantity
        $item->quantity -= 1;
        $item->save();
        return ['code' => 0, 'desc' => 'successful'];
    }


    public function checkout($user_id): array
    {
        Cart::where('user_id', $user_id)->delete();
        return ['code' => 0, 'desc' => 'successful'];
    }

    public function removeFromCart(Request $request): array
    {
        $item = Cart::where('user_id', $request['user_id'])->where('product_id', $request['product_id'])->delete();
        return ['code' => 0, 'desc' => 'successful'];
    }
}
