<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;

class AdminController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        $users = $this->userService->getAllUsers();
        return response()->json(['users' => $users]);
    }

    

}