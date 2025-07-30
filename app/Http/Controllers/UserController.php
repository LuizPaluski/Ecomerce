<?php

namespace App\Http\Controllers;

use App\Enums\UserType;
use App\Models\User;
use App\Repositories\Uploads\ImagenRepository;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function __construct(
       // protected UserRepositoryInterface $userRepository,
       // protected ImagenRepository $imagenRepository,
    ) {
    }
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

    public function uploadImage(Request $request, ImagenRepository $imagenRepository)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $filePath = $imagenRepository->uploadPublicImage($request);

        return response()->json(['file_path' => $filePath], 201);
    }

    public function createModerator(Request $request){
        if($request->user()->role != 'admin'){
            return response()->json(['message' => 'You are not allowed to create moderator']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserType::MODERATOR,

        ]);

        return response()->json($users, 201);


    }
}
