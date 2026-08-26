<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Meta;

class AuthController extends Controller
{
    public function index()
    {
        return view('website.auth.index');
    }

    public function forgot_password()
    {
        return view('website.auth.forgot_password');
    }

    // public function authenticate(Request $request)
    // {
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     $user = User::where('email', '=', $email)->whereNotNull('email_verified_at')->first();

    //     if ($user) {
    //         if (Hash::check($password, $user->password)) {
    //             if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
    //                 $request->session()->regenerate();
                    
    //                 activity('logged-in')
    //                     ->causedBy($user)
    //                     ->performedOn($user)
    //                     ->log('logged-in');

    //                 // if ($user->user_group == 2 || $user->user_group == 3) {
    //                 //     return redirect()->intended(route('home'));
    //                 // } else {
    //                 //     return redirect()->intended(route('admin.dashboard'));
    //                 // }
    //                  // 🚨 Redirect based on user_group
    //             if ($user->user_group == 5) {
    //                 return redirect()->intended(route('supplier.dashboard'));
    //             } elseif (in_array($user->user_group, [1, 4])) {
    //                 return redirect()->intended(route('admin.dashboard'));
    //             } elseif (in_array($user->user_group, [2, 3])) {
    //                 return redirect()->intended(route('home'));
    //             } else {
    //                 return redirect('/'); // fallback if no group
    //             }
    //             }
    //         } else {
    //             $errors = ['email' => 'The provided credentials do not match our records.'];
    //             return redirect()->back()->withErrors($errors);
    //         }
    //     } else {
    //         $errors = ['email' => 'Invalid email address or password.'];
    //         return redirect()->back()->withErrors($errors);
    //     }
    // }

    
    
    public function authenticate(Request $request)
{
    $email = $request->input('email');
    $password = $request->input('password');

    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $email)
                ->whereNotNull('email_verified_at')
                ->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Invalid email address or password.']);
    }

    if (!Hash::check($password, $user->password)) {
        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    // Supplier login (NO status required)
    if ($user->user_group == 5) {
        if (Auth::guard('supplier')->attempt([
            'email' => $email,
            'password' => $password,
        ], $request->filled('remember'))) {

            $request->session()->regenerate();

            activity('logged-in')
                ->causedBy($user)
                ->performedOn($user)
                ->log('logged-in');

            return redirect()->intended(route('supplier.dashboard'));
        }
    } 
    // Other roles (require status = 1)
    else {
        if (Auth::guard('web')->attempt([
            'email' => $email,
            'password' => $password,
            'status' => 1,
        ], $request->filled('remember'))) {

            $request->session()->regenerate();

            activity('logged-in')
                ->causedBy($user)
                ->performedOn($user)
                ->log('logged-in');

            if (in_array($user->user_group, [1, 4, 6, 7])) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif (in_array($user->user_group, [2, 3])) {
                return redirect()->intended(route('home'));
            } else {
                return redirect('/');
            }
        }
    }

    return back()->withErrors(['email' => 'Login failed. Please try again.']);
}

    public function loginvue(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', '=', $email)->whereNotNull('email_verified_at')->first();
        //dd($user);
        if ($user) {
            //check password
            $result = [];
            if (Hash::check($password, $user->password)) {
                //check if user is suspended or blocked
                if ($user->status != 1) {
                    $result = [
                        'success' => false,
                        'message' => 'Sorry, your account is temporarily deactivated. Contact the SSX Team for instructions.'
                    ];
                } else {
                    //check auth
                    if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 1])) {
                        //$user->createToken($email)->plainTextToken;
                        $request->session()->regenerate();

                        activity('logged-in')
                            ->causedBy($user)
                            ->performedOn($user)
                            ->log('logged-in');

                        $result = [
                            'success' => true,
                            'message' => ''
                        ];
                        
                    } else {
                        $result = [
                            'success' => false,
                            'message' => 'Invalid e-mail address or password.'
                        ];
                    }
                }
            } else {
                $result = [
                    'success' => false,
                    'message' => 'Invalid e-mail address or password.'
                ];
            }
        } else {
            $result = [
                'success' => false,
                'message' => 'Invalid e-mail address or password.'
            ];
        }

        return response()->json($result, 200);
    }

    public function forgot_password_request(Request $request)
    {
        $email = $request->input('email');

        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', '=', $email)->where('status', 1)->whereNotNull('email_verified_at')->first();
        
        if ($user) {
            $user->reset_password_token = sha1(time());
            $user->save();

            if (env('APP_ENV') != 'local') {
                Mail::to($user->email)->send(new ResetPassword($user->id));
            } else {
                Mail::to('kgtecson.citem@gmail.com')->send(new ResetPassword($user->id));
            }
            return redirect()->back()->with('status', 'Resetting password link is sent to your email address.');
        } else {
            $errors = ['email' => 'Invalid email address.'];
            return redirect()->back()->withErrors($errors);
        }
    }

    public function reset_password($token)
    {
        if (!empty(session('status_success'))) {
            $user = [];
            Meta::title(env('APP_NAME').' - Reset Password');
        } else {
            $user = User::where('reset_password_token', '=', $token)->whereNotNull('email_verified_at')->firstOrFail();
            Meta::title(env('APP_NAME').' - Reset Password');
        }
        
        Meta::set('robots', env('META_ROBOTS'));
        Meta::set('description', 'SSX is an online portal for you to learn about the latest sustainability practices and source sustainable solutions for your businesses from international providers.');
        Meta::set('author', 'Center for International Trade Expositions and Missions');
        Meta::set('image', '');
        Meta::set('image', asset('/assets/images/ssx-full-logo-white.png'));
        Meta::set('canonical', url()->current());

        return view('website.auth.reset_password', compact('user'));
    }

    public function reset_password_attempt(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::where('status', 1)->where('reset_password_token', '=', $request->input('reset_token'))->whereNotNull('email_verified_at')->firstOrFail();

        $user->password = Hash::make($request->input('password'));
        $user->password_unhash = $request->input('password');
        $user->reset_password_token = NULL;
        $user->save();

        return redirect()->back()->with('status_success', 'Successfully');
    }

    public function authentication($group, $token)
    {   
        $user = User::where('status', 1)->where('reg_token', '=', $token)->whereNull('password')->whereNull('password_unhash')->whereNull('email_verified_at')->firstOrFail();
        return view('website.auth.authentication', ['user' => $user, 'group' => $group]);
    }

    public function create_authentication(Request $request, $group, $token)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $user = User::where('status', 1)->where('reg_token', '=', $token)->whereNull('password')->whereNull('password_unhash')->whereNull('email_verified_at')->firstOrFail();

        $user->password = Hash::make($request->input('password'));
        $user->password_unhash = $request->input('password');
        $user->email_verified_at = Carbon::now();
        $user->reset_password_token = NULL;
        $user->reg_token = NULL;
        $user->save();

        if (env('SSX_API_SYNC')) {
            if ($user->user_group === 2) {
                $this->citemAPIUpdateExhibitor($user->id);
            } else {
                $this->citemAPIUpdateBuyer($user->id);
            }
        }

        if ($user->user_group === 2) {
            return redirect()->route('registration.authentication.thankyou', ['supplier'])->with('status_success', 'Successfully');
        } else {
            return redirect()->route('registration.authentication.thankyou', ['buyer'])->with('status_success', 'Successfully');
        }
    }

    public function thankyou_authentication()
    {
        if (session('status_success')) {
            return view('website.auth.thankyou');
        } else {
            abort(404);
        }
    }
}
