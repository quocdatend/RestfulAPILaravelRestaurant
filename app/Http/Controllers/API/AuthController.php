<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userService->createUser([
            'id' => uniqid(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(UserRequest $request)
    {
        $validated = $request->validated();
        
        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản hoặc mật khẩu không chính xác'],
            ]);
        }

        $user = $this->userService->findUserByEmail($validated['email']);
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản không tồn tại'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Đăng xuất thành công']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'message' => 'Thông tin user profile'
        ]);
    }
}