<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->orders()->with('items.product')->get();
    }

    public function store(StoreOrderRequest $request)
    {

        $validatedData = $request->validated();

        $user = auth()->user();
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => 'Insufficient stock for the product: ' . $item->product->name,
                ], 422);
            }
        }


        $order = DB::transaction(function () use ($user, $cart, $validatedData) {
            $totalPrice = $cart->items->sum(function ($item) {
                return (float)$item->quantity * (float)$item->product->price;
            });

            $finalPrice = $totalPrice;
            $couponId = null;
            $discountValue = null;

                if (!empty($validatedData['coupon_code'])) {
                    $coupon = Coupon::where('code', $validatedData['coupon_code'])
                        ->where('endDate', '>', now())
                        ->first();

                    if ($coupon) {
                        $discountValue = (float)$coupon->discountPercentage / 100 * $totalPrice;
                        $discount = Discount::all()->where('product_id', $coupon->product_id)->first();
                        if ($discount) {
                            $discountValue = (float)$discount->discountPercentage / 100 * $totalPrice;
                        }
                        $finalPrice -= $discountValue;
                        $couponId = $coupon->id;


                    }
                }


            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $validatedData['address_id'],
                'coupon_id' => $couponId,
                'total_price' => $finalPrice,
                'status' => OrderStatus::PENDING,
            ]);


            foreach ($cart->items as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->product->price,
                ]);
                $product = $cartItem->product;
                $product->stock -= $cartItem->quantity;
                $product->save();
}

            $cart->items()->delete();
            $cart->delete();

            return $order;
        });


        return new OrderResource($order->load(['address', 'items.product']));
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
        $request->validate([
            'status' => 'required|in:' . implode(',', OrderStatus::getValues()),
        ]);

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
