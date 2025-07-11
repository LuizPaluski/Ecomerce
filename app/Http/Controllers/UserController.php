<?php

namespace App\Http\Controllers;

use App\Repositories\Uploads\ImagenRepository;
use Dotenv\Validator;
use Illuminate\Http\Request;


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

    public function destroy(Request $request){
        $request->user()->delete();
        return response()->json(['message' => 'User deleted']);
    }

    public function uploadImage(Request $request)
    {
        $coverPath = new ImagenRepository();

        $filePath = $coverPath->uploadPublicImage($request);

        return response()->json(['file_path' => $filePath]);
    }
}
