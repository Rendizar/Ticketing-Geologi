<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

Route::post('/booking', [bookingController::class, 'store']);
Route::post('/payment/callback', [bookingController::class, 'callback']);  // Webhook Midtrans
Route::get('/ticket/{booking_id}', [bookingController::class, 'printTicket']);

Route::match(['get', 'post'], '/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/dashboard', [adminController::class, 'dashboard']);
