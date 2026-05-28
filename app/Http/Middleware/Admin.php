<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // dd($user);
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();

        // Checkpoint 2: Check administrative clearance using a clean array list
        if (!in_array($user->usertype, ['superadmin', 'operatoradmin', 'staff'])) {
            abort(403, 'You do not have permission to access this page.');
        }

        // return $next($request);

        return $next($request);
    }
}
