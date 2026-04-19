<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;


Route::get('/', function () {
    return view('auth.register');
});

// جميع المسارات داخل هذه المجموعة تتطلب تسجيل الدخول
Route::middleware(['auth', 'verified'])->group(function () {

    // صفحة لوحة التحكم الرئيسية
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // مسارات إدارة الأصناف (Items)
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

    // مسارات الفواتير (الوارد والصادر) - لإصلاح أزرار الإضافة السريعة
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/create/{type}', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');

    // مسار نظام الجرد -
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/reports/item-ledger/{id}', [DashboardController::class, 'itemLedger'])->name('item.ledger');

    // مسارات الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // هذا السطر يقوم بتعريف (index, create, store, edit, update, destroy) دفعة واحدة
    Route::resource('items', ItemController::class);
    
    Route::get('/reports/daily', [DashboardController::class, 'dailyReport'])->name('reports.daily');
});

require __DIR__ . '/auth.php';
