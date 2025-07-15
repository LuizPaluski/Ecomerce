<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart;
        if ($cart) {
            $cart->load('items.product');
        }
        return response()->json($cart);
    }

    public function store(Request $request)
    {
        $cart = $request->user()->cart;
        if (!$cart) {
            $cart = $request->user()->cart()->create([]);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        $cart->load('items.product');
        return response()->json($cart);
    }

    public function destroy(Request $request)
    {
        $cart = $request->user()->cart;
        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }
        return response()->json(['message' => 'Cart cleared']);
    }
}
