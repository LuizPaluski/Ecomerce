<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressUserController extends Controller
{

    public function index()
    {

    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'zip_code' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|string',
        ]);
        $request->user()->address()->create($validatedData);
        return response()->json($request->user()->address()->first(), 201);
    }

    public function show(Request $request)
    {
        $request->user()->address()->first();
        if($request->user()->address()->first() == null){
            return response()->json(['message' => 'Address not found, or delete'], 404);
        }
        return response()->json($request->user()->address()->first());
    }


    public function update(Request $request, Address $address)
    {
        $validatedData = $request->validate([
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'country' => 'sometimes|string',
            'zip_code' => 'sometimes|string',
            'street' => 'sometimes|string',
            'number' => 'sometimes|string',
        ]);
        $request->user()->address()->update($validatedData);
        return response()->json($request->user()->address()->first());
    }


    public function destroy(Request $request)
    {
        $request->user()->address()->delete();
        return response()->json(['message' => 'Address deleted']);
    }
}
