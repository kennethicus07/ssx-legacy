<?php

namespace App\Http\Middleware\Supplier;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupplierMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('supplier')->user();

        // Allow access if logged in, verified, and supplier
        if ($user && $user->user_group == 5 && $user->email_verified_at !== null) {
            return $next($request);
        }

        // Skip logging for verification route
        if ($request->routeIs('verification.supplier.verify')) {
            return $next($request);
        }

        // Log access issues
        if (!$user) {
            Log::warning('Supplier access denied: no user logged in.', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
            ]);
        } elseif ($user->user_group != 5) {
            Log::warning('Supplier access denied: wrong user_group.', [
                'user_id' => $user->id,
                'user_group' => $user->user_group,
            ]);
        } elseif (is_null($user->email_verified_at)) {
            Log::warning('Supplier access denied: email not verified.', [
                'user_id' => $user->id,
            ]);
        }
 return redirect()->route('auth.index')->with('error', 'Unauthorized access.');
    }
}