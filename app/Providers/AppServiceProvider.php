<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;
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
    }
}
