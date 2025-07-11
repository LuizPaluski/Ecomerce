<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressUser extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        return response()->json($user->addresses);
    }

    public function store(Address $address, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address' => '|string',
            'city' => '|string',
            'state' => '|string',
            'country' => '|string',
            'zip' => '|string',
        ]);
        $request->only('address', 'city', 'state', 'country', 'zip');
        dd($request);
    }

    public function destroy(Request $request, $id){
        $user = $request->user();
        $user->addresses()->find($id)->delete();
    }

    public function update(Request $request, $id){
        $user = $request->user();
        $user->addresses()->find($id)->update($request->validate([
            'address' => '|string',
            'city' => '|string',
            'state' => '|string',
            'country' => '|string',
            'zip' => '|string',]));

    }

    public function show(Request $request, $id){
        $user = $request->user();
        return response()->json($user->addresses()->find($id));
    }
}
