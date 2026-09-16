<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->user_group != 3) {
                abort(403, 'Unauthorized access to buyer portal.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        return view('website.buyer.dashboard');
    }

    public function account()
    {
        $user = Auth::user();
        return view('website.buyer.account', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        return redirect()->back()->with('status_success', 'Account updated successfully.');
    }

    public function events()
    {
        $user = Auth::user();
        return view('website.buyer.events', compact('user'));
    }

    public function bookmarks()
    {
        $user = Auth::user();
        return view('website.buyer.bookmarks', compact('user'));
    }

    public function toggleBookmark(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Bookmark updated.']);
    }
}