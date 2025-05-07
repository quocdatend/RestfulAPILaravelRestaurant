<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'message' => 'Thông tin user profile'
        ]);
    }
    
    // Các methods khác cho user thông thường
}