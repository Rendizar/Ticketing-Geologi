<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Models\Booking;

// Welcome page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Visitor routes
Route::prefix('tickets')->group(function () {
    Route::get('/create', [BookingController::class, 'create'])->name('tickets.create');
    Route::post('/create', [BookingController::class, 'store'])->name('tickets.store');
    Route::get('/track', [BookingController::class, 'track'])->name('tickets.track');
    Route::post('/track', [BookingController::class, 'checkStatus'])->name('tickets.check-status');
});

// Booking routes
Route::prefix('booking')->group(function () {
    Route::post('/', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/payment/callback', [BookingController::class, 'callback'])->name('booking.payment.callback');
    Route::get('/ticket/{booking_id}', [BookingController::class, 'printTicket'])->name('booking.print-ticket');
});

// Games routes
Route::prefix('games')->group(function () {
    Route::get('/', [GamesController::class, 'index'])->name('games.index');
    Route::get('/tts', [GamesController::class, 'tts'])->name('games.tts');
    Route::get('/quiz', [GamesController::class, 'quiz'])->name('games.quiz');
    Route::get('/memory', [GamesController::class, 'memory'])->name('games.memory');
});

// Payment routes
Route::get('/payment/review', [PaymentController::class, 'review'])->name('payment.review');
Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback')->withoutMiddleware('csrf');

// Knowledge Base routes
Route::prefix('knowledge-base')->group(function () {
    Route::get('/', [KnowledgeBaseController::class, 'index'])->name('knowledge.index');
    Route::get('/{article}', [KnowledgeBaseController::class, 'show'])->name('knowledge.show');
});

// Contact routes
Route::prefix('contact')->group(function () {
    Route::post('/quick-message', [ContactController::class, 'sendQuickMessage'])->name('contact.quick-message');
});


// Review routes
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// Admin routes
Route::prefix('admin')->group(function () {
    // Login & Logout (tanpa middleware)
    Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    // Dashboard & other admin pages
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.tickets.show');
    Route::put('/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.tickets.update');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
    // Sales analytics API
    Route::get('/sales/monthly', [AdminController::class, 'monthlySales'])->name('admin.sales.monthly');
    
    // XLSX Export routes
    Route::get('/export/monthly-xlsx', [AdminController::class, 'exportMonthlyXlsx'])->name('admin.export.monthly');
    Route::get('/export/yearly-xlsx', [AdminController::class, 'exportYearlyXlsx'])->name('admin.export.yearly');
    Route::get('/export/forecast-xlsx', [AdminController::class, 'exportForecastXlsx'])->name('admin.export.forecast');
    
    // Event management routes
    Route::resource('events', App\Http\Controllers\Admin\EventController::class, [
        'as' => 'admin'
    ]);
});