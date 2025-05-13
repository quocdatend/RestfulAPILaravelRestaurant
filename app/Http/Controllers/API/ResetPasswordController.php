<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\ResetPasswordRequest;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function sendMail(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);
        if ($passwordReset) {
            $user->notify(new ResetPasswordRequest($passwordReset->token));
        }
  
        return response()->json([
        'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    // show view reset password if token is valid
    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        // check token is valid
        if(!$passwordReset) {
            return response()->json([
                'message' => 'This password reset token is invalid.',
            ], 422);
        }
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $passwordReset = PasswordReset::where('token', $request->token)->firstOrFail();
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return view('auth.reset-fail');
        }
        $user = User::where('email', $passwordReset->email)->firstOrFail();
        // $updatePasswordUser = $user->update($request->only('password'));
        $passwordReset->delete();

        return view('auth.reset-success');
    }
}
