<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupplierVerificationController extends Controller
{

//     public function verify(Request $request, $id)
// {
//     // ✅ Log out and clear session cache (if someone is logged in)
//     if (Auth::check()) {
//         Auth::logout();
//         $request->session()->invalidate();   // clears session cache
//         $request->session()->regenerateToken(); // regenerates CSRF token
//     }

//     $user = User::findOrFail($id);

//     if ($user->user_group != 5) {
//         abort(403, 'Not a supplier account.');
//     }

//     // Already verified
//     if ($user->email_verified_at) {
//         return redirect()->route('auth.index')
//                          ->with('info', 'Your email is already verified. Please log in.');
//     }

//     // ✅ Verify email
//     $user->email_verified_at = now();
//     $user->save();

//     return redirect()->route('auth.index')
//                      ->with('success', 'Your email has been verified! Please log in to continue.');
// }


public function verify(Request $request, $id)
{
    //  Handle logout for both 'web' and 'supplier' guards
    if (Auth::guard('supplier')->check()) {
        Auth::guard('supplier')->logout();
    }

    if (Auth::check()) {
        Auth::logout();
    }

    // ✅ Clear session cache
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Continue with verification
    $user = User::findOrFail($id);

    if ($user->user_group != 5) {
        abort(403, 'Not a supplier account.');
    }

    // Already verified
    if ($user->email_verified_at) {
        return redirect()->route('auth.index')
                         ->with('info', 'Your email is already verified. Please log in.');
    }

    // ✅ Verify email
    $user->email_verified_at = now();
    $user->status = 1; 
    $user->save();

     // Notify CITEM API if SSX_API_SYNC is enabled
    if (env('SSX_API_SYNC')) {
        try {
            $this->citemAPIValidateStatus($user->email, 'complete', $user->user_group);
        } catch (\Exception $e) {
            Log::error('CITEM API validation failed', [
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }
    }


    return redirect()->route('auth.index')
                     ->with('success', 'Your email has been verified! Please log in to continue.');
}

}
