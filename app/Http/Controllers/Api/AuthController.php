<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'in:provider,customer'
        ]);
        $user = User::create($request->only('email','password','name','role'));
        $token = $user->createToken('authToken')->accessToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'User Has Created'
        ],Response::HTTP_OK);
    }


    public function login(Request $request)
    {
        // 1️⃣ Validate ورودی‌ها
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        // 2️⃣ بررسی credentials در دیتابیس
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // 3️⃣ گرفتن کاربر لاگین شده
        $user = Auth::user();

        // 4️⃣ ساخت token
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5️⃣ برگرداندن پاسخ JSON
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

}
