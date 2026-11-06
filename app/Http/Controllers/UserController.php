<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        // ولیدیشن دقیق فایل آپلودی (فرمت تصویر و حجم حداکثر 2 مگابایت)
        $request->validate([
            'avatar' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = $request->user();

        // اگر کاربر از قبل عکس داشت، عکس قدیمی را پاک کن تا هاست پر نشود
        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        // ذخیره فایل جدید در فولدر avatars واقع در دیسک public
        $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        $user->save();

        return response()->json([
                'success' => true,
                'message' => 'Avatar uploaded successfully',
                'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'avatar_url' => $user->avatar_url, // فراخوانی اکسسور جدید
            ]
        ], 200);
    }
}