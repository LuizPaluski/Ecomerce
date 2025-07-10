<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\User;
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

    public function createModerator(Request $request){
        $user =
        $request->user()->assignPermission('admin');

        if(!$request->user()->hasPermission('admin')){
            return response()->json('error not admin');
        }

        return response()->json('success');
    }


}
