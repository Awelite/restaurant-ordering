<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;

// Public homepage
Route::get('/', function () {
    return view('welcome');
});

// Dashboard for logged-in users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Admin routes — protected by role middleware
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::resource('admin/categories', CategoryController::class)->except('show');
    // 🛎️ Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    // This generates routes like:
    // admin.menu.index
    // admin.menu.create
    // admin.menu.store
    // admin.menu.edit
    // admin.menu.update
    // admin.menu.destroy
    Route::resource('menu', MenuItemController::class);
});



// 👨‍👩‍👧 CUSTOMER ROUTES — Only for role:customer
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        // 🥘 Menu
        Route::get('/menu', [MenuController::class, 'index'])->name('menu');

        // 🛒 Cart
        Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

        // 💳 Checkout
        Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

        // ✅ Order success/receipt
        Route::get('/order/{order}', [CheckoutController::class, 'success'])->name('order.success');
    });

require __DIR__.'/auth.php';
