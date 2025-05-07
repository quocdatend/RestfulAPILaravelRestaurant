<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'stats' => [
                'total_users' => User::where('role', 'user')->count(),
            ],
        ]);
    }

    public function users()
    {
        $users = User::where('role', 'user')->get();
        return response()->json(['users' => $users]);
    }

    

}