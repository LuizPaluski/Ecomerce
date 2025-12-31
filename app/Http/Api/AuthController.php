<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $code = rand(100000, 999999);

        EmailVerification::where('email', $request->email)->delete();

        EmailVerification::create([
            'email' => $request->email,
            'verification_code' => $code
        ]);

        Mail::raw("Seu código de verificação: $code", function ($message) use ($request) {
            $message->to($request->email)->subject('Código de Verificação');
        });

        return response()->json(['message' => 'Código enviado.'], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'code_email' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $verification = EmailVerification::where('email', $request->email)
                        ->where('verification_code', $request->code_email)
                        ->first();

        if (!$verification || Carbon::parse($verification->created_at)->addMinutes(10)->isPast()) {
            return response()->json(['message' => 'Código inválido ou expirado.'], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $verification->delete();

        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function renewToken(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Hash::check($request->password, $request->user()->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $request->user()->tokens()->delete();
        $token = $request->user()->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function verifyToken(Request $request)
    {
        return response()->json([
            'acess_token' => $request->bearerToken(),
        ]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        
        if (!Hash::check($request->password, $request->user()->password)) {
             return response()->json(['message' => 'Invalid password'], 403);
        }

        $request->user()->delete();
        return response()->json(['message' => 'User deleted']);
    }
}