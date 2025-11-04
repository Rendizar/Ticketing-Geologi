<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;

// Welcome page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Visitor routes
Route::prefix('tickets')->group(function () {
    Route::get('/', [VisitorController::class, 'create'])->name('tickets.create');
    Route::post('/', [VisitorController::class, 'store'])->name('tickets.store');
    Route::get('/track', [VisitorController::class, 'track'])->name('tickets.track');
    Route::post('/track', [VisitorController::class, 'checkStatus'])->name('tickets.check-status');
});

// Booking routes
Route::prefix('booking')->group(function () {
    Route::post('/', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/payment/callback', [BookingController::class, 'callback'])->name('booking.payment.callback');
    Route::get('/ticket/{booking_id}', [BookingController::class, 'printTicket'])->name('booking.print-ticket');
});

// Knowledge Base routes
Route::prefix('knowledge-base')->group(function () {
    Route::get('/', [KnowledgeBaseController::class, 'index'])->name('knowledge.index');
    Route::get('/{article}', [KnowledgeBaseController::class, 'show'])->name('knowledge.show');
});

// Contact routes
Route::prefix('contact')->group(function () {
    Route::post('/quick-message', [ContactController::class, 'sendQuickMessage'])->name('contact.quick-message');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.tickets.show');
    Route::put('/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.tickets.update');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
});
