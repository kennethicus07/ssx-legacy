<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SSOController extends Controller
{
    /**
     * Check auth and send user back to B2B portal with a signed token.
     */
    public function authorizeB2B(Request $request)
    {
        $redirectUri = $request->query('redirect_uri');

        if (!$redirectUri) {
            abort(400, 'Missing redirect URI.');
        }

        // If the user is NOT logged into the main site, redirect them to the main site login page,
        // and tell the main site login page to redirect them back to this SSO route after logging in.
        if (!Auth::check()) {
            return redirect()->route('login')->with('url.intended', $request->fullUrl());
        }

        $user = Auth::user();
        $timestamp = now()->timestamp;
        $secret = env('SSO_SHARED_SECRET');

        // Generate a secure HMAC SHA-256 signature using the shared secret
        $signature = hash_hmac('sha256', $user->email . $timestamp, $secret);

        // Build the callback URL with the encrypted payload
        $callbackUrl = $redirectUri . '?' . http_build_query([
            'email' => $user->email,
            'timestamp' => $timestamp,
            'signature' => $signature
        ]);

        return redirect($callbackUrl);
    }
}