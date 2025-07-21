<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Enums\OrderStatus;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->orders()->with('items.product')->get();
    }
    public function store(Request $request)
    {
//        $validateData = $request->validate([
//            'address_id' => 'required|exists:addresses,id',
//            'coupon_id' => 'sometimes|exists:coupons,id',
//        ]);

        $cart = $request->user()->cart()->with('items.product.discounts')->first();
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalPrice = 0;
        foreach ($cart->items as $item) {
            $productPrice = $item->product->price;
            $discountPercentage = 0;


            foreach ($item->product->discounts as $discount) {
                $discountPercentage += $discount->discountPercentage;
            }


            if ($discountPercentage > 100) {
                $discountPercentage = 100;
            }

            $discountedPrice = $productPrice * (1 - ($discountPercentage / 100));
            $totalPrice += $discountedPrice * $item->quantity;
        }


        if ($request->coupon_id) {
            $coupon = Coupon::find($request->coupon_id);
            if ($coupon) {
                $totalPrice *= (1 - ($coupon->discountPercentage / 100));
            }
        }
        $order = $request->user()->orders()->create([
            'address_id' => $request->address_id,
            'coupon_id' => $request->coupon_id,
            'status' => OrderStatus::PENDING,
            'total_price' => $totalPrice,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unitPrice' => $item->product->price,
            ]);
        }
        $cart->items()->delete();
        $cart->delete();

        return response()->json($order->load('items.product'), 201);
    }
    public function show(Request $request, Order $order)
    {
        if ($request->user()->id !== $order->user_id && $request->user()->role !== 'admin' && $request->user()->role !== 'moderator') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $order->load('items.product', 'address', 'coupon');
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->only('status'));
        return response()->json($order);
    }

    public function destroy(Request $request, Order $order)
    {
        if ($request->user()->id !== $order->user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $order->status = OrderStatus::CANCELLED;
        $order->save();
        return response()->json($order);
    }
}
