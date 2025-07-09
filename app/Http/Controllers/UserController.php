<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request){
        $user = $request->user();
        return response()->json($user);

    }

    public function update(Request $request){
        $request->user();
        $update = $request->validate([
            'name' => '|string',
            'email' => '|email|',
            'password' => '|min:8|',
        ]);
        $request->user()->update($update);
        return response()->json($request->user());
    }


}
