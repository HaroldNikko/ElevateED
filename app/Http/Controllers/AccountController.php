<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Login;

class AccountController extends Controller
{
   public function changePassword(Request $request)
{
    Log::info('Change password request triggered');

    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $loginId = session('Login_id');
    Log::info("Login ID from session: " . ($loginId ?? 'NULL'));

    if (!$loginId) {
        return back()->with('error', 'Session expired. Please log in again.');
    }

    $user = Login::find($loginId);

    if (!$user) {
        Log::warning("User not found for Login_id: $loginId");
        return back()->with('error', 'User not found.');
    }

    Log::info("User found: $user->username");

    if (!Hash::check($request->current_password, $user->password)) {
        Log::warning("Incorrect current password for Login_id: $loginId");
        return back()->withErrors(['current_password' => 'The current password you entered is incorrect.'])->withInput();
    }

    Log::info("Before update: Password hash = " . $user->password);

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        $user = Login::find($loginId); // 🔁 Re-fetch to ensure it's updated
        Log::info("After update: Password hash = " . $user->password);;

    return back()->with('success', 'Password successfully updated!');
}


    public function checkCurrentPassword(Request $request)
    {
        try {
            $loginId = session('Login_id');
            $user = Login::find($loginId);

            if (!$user) {
                Log::warning("Password check failed: user not found (Login_id: $loginId)");
                return response()->json(['valid' => false]);
            }

            $isCorrect = Hash::check($request->current_password, $user->password);
            Log::info("Real-time password check for Login_id $loginId: " . ($isCorrect ? 'valid' : 'invalid'));

            return response()->json(['valid' => $isCorrect]);
        } catch (\Exception $e) {
            Log::error("Password check error (Login_id: $loginId): " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
