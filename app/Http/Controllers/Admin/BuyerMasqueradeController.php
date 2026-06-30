<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerMasqueradeController extends Controller
{
    /**
     * Authenticate the active administrator into the target buyer profile proxy state.
     */
    public function loginAsBuyer(Request $request, $id)
    {
        // 1. Verify that the user executing this action is an authenticated Admin
        if (!Auth::guard('web')->check()) {
            abort(403, 'Unauthorized administrative action context.');
        }

        // 2. Hydrate the target enterprise buyer profile matrix
        $buyer = BuyerProfile::findOrFail($id);

        // 3. Stash a fallback configuration tracker token inside the session
        // This preserves the admin's original state for clean rollbacks
        $request->session()->put('admin_masquerader_id', Auth::guard('web')->id());

        // 4. Force a silent backend login execution under the buyer guard
        Auth::guard('buyer')->login($buyer);

        // 5. Regenerate the underlying session footprint token to patch potential anomalies
        $request->session()->regenerate();

        return redirect()->route('buyer.dashboard')
            ->with('success', "Proxy session established. You are now masquerading as: '{$buyer->company_name}'");
    }

    /**
     * Terminate the active proxy session and return to the Admin panel.
     */
    public function logoutAsBuyer(Request $request)
    {
        if ($request->session()->has('admin_masquerader_id')) {

            // Log out from the buyer guard strictly
            Auth::guard('buyer')->logout();

            // Purge the tracking parameter context token
            $request->session()->forget('admin_masquerader_id');

            $request->session()->regenerate();

            return redirect()->route('admin.buyers.manage')
                ->with('success', 'Proxy masquerade dropped. Returned safely to administrative workspace index directory.');
        }

        abort(403, 'No proxy masquerade context active.');
    }
}
