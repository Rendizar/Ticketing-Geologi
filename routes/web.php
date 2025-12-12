<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VisitorController;

// Welcome page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

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
// // Event routes
// Route::prefix('events')->group(function () {
//     Route::get('/{event}', [EventController::class, 'show'])->name('events.show');
//     Route::post('/{event}/book', [EventController::class, 'book'])->name('events.book');
// });


// Review routes
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.tickets.show');
    Route::put('/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.tickets.update');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
    
    // Event management routes
    Route::resource('events', App\Http\Controllers\Admin\EventController::class, [
        'as' => 'admin'
    ]);
});
