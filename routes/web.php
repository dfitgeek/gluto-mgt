<?php

use App\Http\Controllers\Admin\CreateSupplier as CreateSuppliers;
use App\Http\Controllers\CreateBuyers as CreateBuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSaveBuyerProfile;
use App\Http\Controllers\UserSaveSupplierProfile;
use App\Http\Middleware;
use App\Livewire\Admin\BuyerDashboard;
use App\Livewire\Admin\CreateSupplier;
use App\Livewire\Admin\Lobby;
use App\Livewire\Admin\ManageSuppliers;
use App\Livewire\Admin\SupplierDashboard;
use App\Livewire\Admin\VerifiedBuyers;
use App\Livewire\Admin\VerifiedSuppliers;
use App\Livewire\AdminLogin;
use App\Livewire\CreateBuyers;
use App\Livewire\ManageBuyers;
use App\Livewire\OnboardingTokens;
use App\Livewire\UserCreateBuyerProfile;
use App\Livewire\UserCreateSupplierProfile;
use App\Livewire\UserSupplierProfileLogin;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', AdminLogin::class)->name('admin.login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user/register/supplier/{token}/create', UserCreateSupplierProfile::class)->name('admin.suppliers.user.create');

Route::post('/user/register/supplier/{token}/save', [UserSaveSupplierProfile::class, 'store'])->name('admin.suppliers.user.store');

Route::get('/guest/supplier/login', UserSupplierProfileLogin::class)->name('supplier.login');

Route::get('/user/register/buyer/{token}/create', UserCreateBuyerProfile::class)->name('admin.buyer.user.create');

Route::post('/user/register/buyer/{token}/save', [UserSaveBuyerProfile::class, 'store'])->name('admin.buyer.user.store');

Route::get('/admin/dashboard/onboarding-tokens', OnboardingTokens::class)->name('admin.onboarding.tokens');


Route::get('/hello', function () {
    return 'Hello, World!';
})->middleware('role.buyer')->name('hello');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('role.admin')->group(function () {
    Route::get('/admin/dashboard', Lobby::class)->name('admin.lobby');

    // Supplier Mgt
    Route::get('/admin/dashboard/suppliers', SupplierDashboard::class)->name('admin.suppliers');

    Route::get('/admin/dashboard/suppliers/manage', ManageSuppliers::class)->name('admin.suppliers.manage');

    Route::get('/admin/dashboard/suppliers/create', CreateSupplier::class)->name('admin.suppliers.create');



    Route::post('/admin/dashboard/suppliers/store', [CreateSuppliers::class, 'store'])->name('admin.suppliers.store');


    // Supplier Facing Onboarding Form Routes
    // Route::get('/supplier/onboarding/{token}', \App\Livewire\Supplier\PersonalCreateProfile::class)
    //     ->name('supplier.personal.create');

    // Route::post('/supplier/onboarding/{token}/save', [\App\Http\Controllers\Supplier\PersonalSaveProfileController::class, 'store'])
    //     ->name('supplier.personal.store');


    // Buyer Mgt
    Route::get('/admin/dashboard/buyers', BuyerDashboard::class)->name('admin.buyers');

    Route::get('/admin/dashboard/buyers/manage', ManageBuyers::class)->name('admin.buyers.manage');

    Route::get('/admin/dashboard/buyers/create', CreateBuyers::class)->name('admin.buyers.create');

    Route::post('/admin/dashboard/buyers/store', [CreateBuyerController::class, 'store'])->name('admin.buyers.store');




    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
