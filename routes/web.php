<?php

use App\Http\Controllers\Admin\BuyerMasqueradeController;
use App\Http\Controllers\Admin\CreateSupplier as CreateSuppliers;
use App\Http\Controllers\Admin\SupplierMasqueradeController;
use App\Http\Controllers\CreateBuyers as CreateBuyerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAuthenticatables;
use App\Http\Controllers\UserSaveBuyerProfile;
use App\Http\Controllers\UserSaveSupplierProfile;
use App\Http\Middleware;
use App\Livewire\Admin\BuyerDashboard;
use App\Livewire\Admin\BuyerTracker as AdminBuyerTracker;
use App\Livewire\Admin\CreateSupplier;
use App\Livewire\Admin\Lobby;
use App\Livewire\Admin\ManageSuppliers;
use App\Livewire\Admin\SupplierDashboard;
use App\Livewire\Admin\SupplierProducts;
use App\Livewire\Admin\SupplierTracker;
use App\Livewire\Admin\VerifiedBuyers;
use App\Livewire\Admin\VerifiedSuppliers;
use App\Livewire\AdminLogin;
use App\Livewire\Buyer\BuyerDocumentLibrary;
use App\Livewire\Buyer\BuyerOrder;
use App\Livewire\Buyer\BuyerProfile;
use App\Livewire\Buyer\BuyerTracker;
use App\Livewire\BuyerLogin;
use App\Livewire\CreateBuyers as CreateBuyerPage;
use App\Livewire\ManageBuyers;
use App\Livewire\OnboardingTokens;
use App\Livewire\OrderPage;
use App\Livewire\Supplier\CreateProductCatalogue;
use App\Livewire\Supplier\EditProductCatalogue;
use App\Livewire\Supplier\ManageProductCatalogue;
use App\Livewire\Supplier\ManageSupplierProfile;
use App\Livewire\Supplier\ProformaOrder;
use App\Livewire\Supplier\SupplierDocumentLibrary;
use App\Livewire\Supplier\SupplierTracker as UserTracker;
use App\Livewire\SupplierDashboard as UserSupplierDashboard;
use App\Livewire\SupplierLogin;
use App\Livewire\UserCreateBuyerProfile;
use App\Livewire\UserCreateSupplierProfile;
use App\Livewire\UserSupplierProfileLogin;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', AdminLogin::class)->name('admin.login');

Route::get('/login/supplier', SupplierLogin::class)->name('supplier.login');

Route::get('/login/buyer', BuyerLogin::class)->name('buyer.login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/user/register/supplier/{token}/create', UserCreateSupplierProfile::class)->name('admin.suppliers.user.create');

Route::post('/user/register/supplier/{token}/save', [UserSaveSupplierProfile::class, 'store'])->name('admin.suppliers.user.store');

// Route::get('/guest/supplier/login', UserSupplierProfileLogin::class)->name('supplier.login');

Route::get('/user/register/buyer/{token}/create', UserCreateBuyerProfile::class)->name('admin.buyer.user.create');

Route::post('/user/register/buyer/{token}/save', [UserSaveBuyerProfile::class, 'store'])->name('admin.buyer.user.store');


Route::get('/hello', function () {
    return 'Hello, World!';
})->middleware('role.buyer')->name('hello');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Testuser$1234

Route::middleware('role.supplier')->group(function () {
    Route::get('/dashboard/supplier', UserSupplierDashboard::class)->name('supplier.dashboard');

    Route::post('/supplier/logout', [UserAuthenticatables::class, 'supplierLogout'])->name('supplier.logout');

    Route::get('/dashboard/supplier/products', ManageProductCatalogue::class)->name('supplier.products');

    Route::get('/dashboard/supplier/product/create', CreateProductCatalogue::class)->name('supplier.product.create');

    Route::post('/dashboard/supplier/product/store', [\App\Http\Controllers\Supplier\CreateProductCatalogue::class, 'store'])->name('supplier.products.store');

    Route::get('dashboard/supplier/product/{id}/edit', EditProductCatalogue::class)->name('supplier.product.edit');

    Route::post('/dashboard/supplier/product/{id}/edit/update', [\App\Http\Controllers\Supplier\UpdateProductCatalogue::class, 'update'])->name('supplier.products.update');

    Route::get('/dashboard/supplier/profile', ManageSupplierProfile::class)->name('supplier.profile');

    Route::get('/dashboard/supplier/profile/documents', SupplierDocumentLibrary::class)->name('supplier.profile.documents');

    Route::get('/dashboard/supplier/orders', ProformaOrder::class)->name('supplier.orders');

    Route::get('/dashboard/supplier/tracker', UserTracker::class)->name('supplier.profile.tracker');

    Route::post('/supplier/masquerade-exit', [SupplierMasqueradeController::class, 'logoutAsSupplier'])
        ->name('supplier.masquerade.exit');


});

Route::middleware('role.buyer')->group(function () {
    Route::get('/dashboard/buyer', \App\Livewire\Buyer\BuyerDashboard::class)->name('buyer.dashboard');

    Route::get('/buyer/manageprofile', BuyerProfile::class)->name('buyer.profile');

    Route::get('/buyer/buyerorder', BuyerOrder::class)->name('buyer.order');

    Route::get('/buyer/documents', BuyerDocumentLibrary::class)->name('buyer.documents');

    Route::post('/buyer/logout', [UserAuthenticatables::class, 'buyerLogout'])->name('buyer.logout');

    Route::get('/buyer/catalogue', OrderPage::class)->name('buyer.product');

    Route::get('/buyer/catalogue/provision-order', \App\Livewire\Buyer\BuyerOrderData::class)
        ->name('orders.create'); // Matches naming requirements to prevent configuration exceptions loops

    Route::get('/buyer/tracker', BuyerTracker::class)->name('buyer.tracker');

    Route::post('/buyer/masquerade-exit', [BuyerMasqueradeController::class, 'logoutAsBuyer'])
        ->name('buyer.masquerade.exit');
});

Route::middleware('role.admin')->group(function () {
    Route::get('/admin/dashboard', Lobby::class)->name('admin.lobby');

    // Supplier Mgt
    Route::get('/admin/dashboard/suppliers', SupplierDashboard::class)->name('admin.suppliers');

    Route::get('/admin/dashboard/suppliers/manage', ManageSuppliers::class)->name('admin.suppliers.manage');

    Route::get('/admin/dashboard/suppliers/create', CreateSupplier::class)->name('admin.suppliers.create');

    Route::get('/admin/dashboard/onboarding-tokens', OnboardingTokens::class)->name('admin.onboarding.tokens');


    Route::post('/admin/dashboard/supplier/store', [CreateSuppliers::class, 'store'])->name('admin.suppliers.store');


    Route::get('/admin/dashboard/supplier/{id}/product', SupplierProducts::class)->name('admin.suppliers.products');

    Route::get('/admin/dashboard/supplier/{id}/track', SupplierTracker::class)->name('admin.suppliers.track');

    Route::get('/admin/dashboard/buyer/{id}/track', AdminBuyerTracker::class)->name('admin.buyers.track');

    Route::post('logout', [UserAuthenticatables::class, 'adminLogout'])
        ->name('logout');

    Route::get('/admin/suppliers/{id}/masquerade-login', [SupplierMasqueradeController::class, 'loginAsSupplier'])
        ->name('admin.suppliers.masquerade');


    // Supplier Facing Onboarding Form Routes
    // Route::get('/supplier/onboarding/{token}', \App\Livewire\Supplier\PersonalCreateProfile::class)
    //     ->name('supplier.personal.create');

    // Route::post('/supplier/onboarding/{token}/save', [\App\Http\Controllers\Supplier\PersonalSaveProfileController::class, 'store'])
    //     ->name('supplier.personal.store');


    // Buyer Mgt
    Route::get('/admin/dashboard/buyers', BuyerDashboard::class)->name('admin.buyers');

    Route::get('/admin/dashboard/buyers/manage', ManageBuyers::class)->name('admin.buyers.manage');

    Route::get('/admin/dashboard/buyers/create', CreateBuyerPage::class)->name('admin.buyers.create');

    Route::post('/admin/dashboard/buyers/store', [CreateBuyerController::class, 'store'])->name('admin.buyers.store');

    Route::get('/admin/buyers/{id}/masquerade-login', [BuyerMasqueradeController::class, 'loginAsBuyer'])
        ->name('admin.buyers.masquerade');

    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
