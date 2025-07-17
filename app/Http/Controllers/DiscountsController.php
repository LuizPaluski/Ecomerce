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
        $validatedData = $request->validate([
            'description' => 'required|string',
            'discountPercentage' => 'required|numeric|min:0|max:100',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'product_id' => 'required|exists:products,id',
        ]);

        $discount = Discount::create($validatedData);

        return response()->json($discount, 201);
    }

    public function show(Discount $discount)
    {
        return $discount;
    }

    public function update(Request $request, Discount $discount)
    {
        $validatedData = $request->validate([
            'description' => 'sometimes|required|string',
            'discountPercentage' => 'sometimes|required|numeric|min:0|max:100',
            'startDate' => 'sometimes|required|date',
            'endDate' => 'sometimes|required|date|after_or_equal:startDate',
        ]);

        $discount->update($validatedData);
        return response()->json($discount);
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(['message' => 'Discount deleted']);
    }
}
