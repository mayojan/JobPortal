<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // متد ثبت‌نام کاربر جدید (Register)
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|string|in:candidate,employer', // اضافه شدن فیلد نقش پروژه شما
        ]);

        $user = User::create($data); // رمز عبور توسط مادل به صورت خودکار هش می‌شود

        return response()->json([
            'user'  => $user,
            'token' => $user->createToken('api')->plainTextToken,
        ], 201);
    }

    // متد ورود کاربر (Login)
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $data['email'])->first();

        // چک کردن وجود کاربر و درست بودن پسورد
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'user'  => $user,
            'token' => $user->createToken('api')->plainTextToken,
        ]);
    }

    // متد خروج کاربر و باطل کردن توکن (Logout)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent(); // کد 204 No Content
    }
}
