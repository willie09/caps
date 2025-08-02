<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\WalkInLogController;
use App\Http\Controllers\InventoryController;
use App\Models\Member;
use App\Models\WalkInLog;
use App\Models\Expense;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    // Inventory routes
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventories', [InventoryController::class, 'store'])->name('inventories.store');
    Route::delete('/inventories/{inventory}', [InventoryController::class, 'destroy'])->name('inventories.destroy');
    Route::patch('/inventories/{inventory}', [InventoryController::class, 'update'])->name('inventories.update');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Member routes
    Route::get('/members', [MemberController::class, 'index'])->name('members.list');
    Route::resource('members', MemberController::class)
        ->except(['index', 'show'])
        ->names([
            'create' => 'members.create',
            'store' => 'members.store',
            'edit' => 'members.edit',
            'update' => 'members.update',
            'destroy' => 'members.destroy'
        ]);

    // WalkIn routes
    Route::get('/walkins', [WalkInLogController::class, 'index'])->name('walkins');
    Route::delete('/walkins/{id}', [WalkInLogController::class, 'destroy'])->name('walkins.destroy');
    Route::post('/walkins', [WalkInLogController::class, 'store'])->name('walkins.store');

    // Finance route
    Route::get('/finance', [\App\Http\Controllers\MemberController::class, 'finance'])->name('finance');

    // Expense routes
    Route::get('/expenses', [\App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [\App\Http\Controllers\ExpenseController::class, 'store'])->name('expenses.store');

    // Member notify routes
    Route::get('/members/notify-expiry', [MemberController::class, 'notifyExpiryForm'])->name('members.notifyExpiryForm');
    Route::post('/members/notify-expiry', [MemberController::class, 'sendExpiryNotifications'])->name('members.sendExpiryNotifications');
    Route::post('/members/{id}/notify', [MemberController::class, 'notifyMember'])->name('members.notifyMember');

    // Orders route
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');
});

require __DIR__.'/auth.php';
