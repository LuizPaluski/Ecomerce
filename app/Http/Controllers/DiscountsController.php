<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    public function index()
    {
        return Discount::all();
    }

    public function store(Request $request)
    {
        $discount = Discount::create($request->all());
        return response()->json($discount, 201);
    }

    public function show(Discount $discount)
    {
        return $discount;
    }

    public function update(Request $request, Discount $discount)
    {
        $discount->update($request->all());
        return response()->json($discount);
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(['message' => 'Discount deleted']);
    }
}
