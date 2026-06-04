<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Gate::before(function (User $user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // 2. Gate to check who can delete records (Strict: Super Admin only)
        Gate::define('delete-record', function (User $user) {
            return $user->isSuperAdmin(); // Operations Admin & Staff explicitly return false
        });

        // 3. Gate for modifying/updating data (Super Admin & Operations Admin can [cite: 86, 87])
        Gate::define('modify-record', function (User $user) {
            return $user->isSuperAdmin() || $user->isOperationsAdmin();
        });

        // 4. Custom Blade directive to check specific admin types in your UI cleanly
        Blade::if('adminType', function (array $types) {
            return auth()->check() && in_array(auth()->user()->usertype, $types);
        });

        View::composer('layouts.admin', function ($view) {
            $currentAccount = null;
            $statusLabel = 'System Personnel';
            $iconPath = null;

            // 1. Check if an Admin (default 'web' guard) is logged in
            if (Auth::guard('web')->check()) {
                $currentAccount = Auth::guard('web')->user();
                $statusLabel = 'Super Admin'; // Hardcoded profile badge for system staff
            }
            // 2. Check if a Supplier account guard is logged in instead
            elseif (Auth::guard('supplier')->check()) {
                $supplierUser = Auth::guard('supplier')->user();

                // Since the model IS the supplier account, we can fetch its data directly
                // (Or query its attached profile if you have a separate profile table)
                $currentAccount = $supplierUser;
                $statusLabel = $supplierUser->status_label ?? 'Unverified Supplier';
                $iconPath = $supplierUser->company_icon_path ?? null;
            }

            // Bind separate clean variables to use inside the layout shell
            $view->with([
                'layoutUser' => $currentAccount,
                // 'layoutStatus' => $statusLabel,
                // 'layoutIcon' => $iconPath,
            ]);
        });
    }
}
