<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//PELANGGAN (publik, tanpa login)
Route::get('/', [OrderController::class, 'index'])->name('customer.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('customer.checkout');

//ADMIN: dashboard rekap pesanan (wajib login)
Route::get('/dashboard', [OrderController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])->name('dashboard');

//ADMIN: semua route di dalam grup ini wajib login
Route::middleware('auth')->group(function () {
    //Profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Ubah status pesanan
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');

    //CRUD event: events.index, create, store, edit, update, destroy
    Route::resource('/admin/events', EventController::class)->except(['show']);
});

//Login, logout, dll (bawaan Breeze)
require __DIR__.'/auth.php';
