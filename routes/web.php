<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware;
use App\Livewire\Admin\BuyerDashboard;
use App\Livewire\Admin\Lobby;
use App\Livewire\Admin\SupplierDashboard;
use App\Livewire\Admin\VerifiedBuyers;
use App\Livewire\Admin\VerifiedSuppliers;
use App\Livewire\AdminLogin;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', AdminLogin::class)->name('admin.login');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

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

    Route::get('/admin/dashboard/suppliers/verified', VerifiedSuppliers::class)->name('admin.suppliers.verified');

    Route::get('/admin/dashboard/suppliers/unverified', VerifiedSuppliers::class)->name('admin.suppliers.unverified');

    // Buyer Mgt
    Route::get('/admin/dashboard/buyers', BuyerDashboard::class)->name('admin.buyers');

    Route::get('/admin/dashboard/buyers/vb', VerifiedBuyers::class)->name('admin.buyers.verified');

    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
