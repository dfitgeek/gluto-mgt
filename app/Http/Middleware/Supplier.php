<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Supplier
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('supplier')->check()) {

            // If it's an AJAX/Livewire payload request, return a clean JSON error response

            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated supplier context.'], 401);
            }


            // Otherwise, boot them straight back to your representative login screen with an alert note
            return redirect()->route('supplier.login')->with('error', 'Please authenticate with your representative credentials to access this section.');
        }

        return $next($request);
    }
}
