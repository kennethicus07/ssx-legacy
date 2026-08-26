<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.user_accounts.changepassword');
    }

    public function update(Request $request)
    {
        $user_id = Auth::id();

        if (!empty($user_id)) {
            $user = User::findOrFail($user_id);

            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
                'new_password_confirmation' => 'required|min:8'
            ]);

            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
                $user->password_unhash = $request->input('new_password');
                $user->save();
                
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/login');
            } else {
                $errors = ['current_password' => 'The provided password does not match our records.'];
                return redirect()->back()->withErrors($errors);
            }
        }
    }
}
