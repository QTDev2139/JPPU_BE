<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Chức năng Đăng ký (Register)
    public function register(UserRequest $request)
    {
        // Tạo User mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Cấp Token ngay sau khi đăng ký thành công (tùy chọn)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký tài khoản thành công!',
            'data' => $user,
            'access_token' => $token,
        ], 201);
    }

    // Chức năng Đăng nhập (Login)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Kiểm tra email và mật khẩu
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }

        // Lấy thông tin User hiện tại
        $user = User::where('email', $request->email)->firstOrFail();

        // Tạo token mới cho thiết bị này
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thành công!',
            'access_token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ], 200);
    }

    // Chức năng Đăng xuất (Logout)
    public function logout(Request $request)
    {
        // Xóa token hiện tại đang dùng để gửi request này
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã đăng xuất và hủy token thành công.'
        ], 200);
    }
}
