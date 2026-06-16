<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAuthenticatables extends Controller
{
    //

    public function supplierLogout(Request $request)
    {
        auth()->guard('supplier')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('supplier.login')->with('success', 'You have been logged out of your representative session successfully.');
    }

    public function buyerLogout(Request $request)
    {
        auth()->guard('buyer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
