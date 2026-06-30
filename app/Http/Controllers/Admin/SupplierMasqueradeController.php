<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupplierProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierMasqueradeController extends Controller
{
    /**
     * Authenticate the active administrator into the target supplier profile proxy state.
     */
    public function loginAsSupplier(Request $request, $id)
    {
        // 1. Verify that the user executing this action is an authenticated Admin
        if (!Auth::guard('web')->check()) {
            abort(403, 'Unauthorized administrative action context.');
        }

        // 2. Hydrate the target supplier profile matrix
        $supplier = SupplierProfile::findOrFail($id);

        // 3. Stash a fallback configuration tracker token inside the session
        $request->session()->put('admin_supplier_masquerader_id', Auth::guard('web')->id());

        // 4. Force a silent backend login execution under the supplier guard
        Auth::guard('supplier')->login($supplier);

        // 5. Regenerate the underlying session footprint token
        $request->session()->regenerate();

        return redirect()->route('supplier.dashboard')
            ->with('success', "Proxy session established. You are now masquerading as: '{$supplier->company_name}'");
    }

    /**
     * Terminate the active proxy session and return to the Admin panel.
     */
    public function logoutAsSupplier(Request $request)
    {
        if ($request->session()->has('admin_supplier_masquerader_id')) {

            // Log out from the supplier guard strictly
            Auth::guard('supplier')->logout();

            // Purge the tracking parameter context token
            $request->session()->forget('admin_supplier_masquerader_id');

            $request->session()->regenerate();

            return redirect()->route('admin.suppliers.manage')
                ->with('success', 'Proxy masquerade dropped. Returned safely to administrative workspace index directory.');
        }

        abort(403, 'No proxy masquerade context active.');
    }
}
