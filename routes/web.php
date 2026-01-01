<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpecialTicketController;
use App\Models\Booking;

// Welcome page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Fallback login route (redirect to home for visitors, they don't need login)
Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

// Visitor routes
Route::prefix('tickets')->group(function () {
    Route::get('/create', [BookingController::class, 'create'])->name('tickets.create');
    Route::post('/create', [BookingController::class, 'store'])->name('tickets.store');
    Route::get('/track', [BookingController::class, 'track'])->name('tickets.track');
    Route::post('/track', [BookingController::class, 'checkStatus'])->name('tickets.check-status');
    Route::get('/slot-availability', [BookingController::class, 'getSlotAvailability'])->name('tickets.slot-availability');
    
    // Reschedule routes
    Route::get('/reschedule', [BookingController::class, 'rescheduleForm'])->name('tickets.reschedule.form');
    Route::post('/reschedule/check', [BookingController::class, 'rescheduleCheck'])->name('tickets.reschedule.check');
    Route::get('/reschedule/edit/{booking_id}', [BookingController::class, 'rescheduleEdit'])->name('tickets.reschedule.edit');
    Route::post('/reschedule/update', [BookingController::class, 'rescheduleUpdate'])->name('tickets.reschedule.update');
});

// Booking routes
Route::prefix('booking')->group(function () {
    Route::post('/', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/payment/callback', [BookingController::class, 'callback'])->name('booking.payment.callback');
    Route::get('/ticket/{booking_id}', [BookingController::class, 'printTicket'])->name('booking.print-ticket');
});

// Event Booking routes
Route::prefix('event/booking')->group(function () {
    Route::get('/{event_id}', [EventBookingController::class, 'create'])->name('event.booking.create');
    Route::post('/store', [EventBookingController::class, 'store'])->name('event.booking.store');
    Route::get('/ticket/{booking_id}', [EventBookingController::class, 'printTicket'])->name('event.booking.ticket');
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

// Event Payment routes
Route::get('/event/payment/review', [PaymentController::class, 'eventReview'])->name('event.payment.review');
Route::post('/event/payment/initiate', [PaymentController::class, 'eventInitiate'])->name('event.payment.initiate');
Route::get('/event/payment/finish', [PaymentController::class, 'eventFinish'])->name('event.payment.finish');

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

// Special Ticket routes (visitor-facing)
Route::prefix('special-tickets')->group(function () {
    Route::get('/create', [SpecialTicketController::class, 'create'])->name('special-tickets.create');
    Route::post('/store', [SpecialTicketController::class, 'store'])->name('special-tickets.store');
    Route::get('/success', [SpecialTicketController::class, 'success'])->name('special-tickets.success');
    Route::post('/check-status', [SpecialTicketController::class, 'checkStatus'])->name('special-tickets.check-status');
});

// Admin routes
Route::prefix('admin')->group(function () {
    // Login (tanpa middleware - accessible without authentication)
    Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->name('admin.login');
    
    // Protected admin routes (requires authentication)
    Route::middleware(['auth:admin'])->group(function () {
        // Logout
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
        
        // Dashboard & other admin pages
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/tickets/{ticket}', [AdminController::class, 'show'])->name('admin.tickets.show');
    Route::put('/tickets/{ticket}', [AdminController::class, 'update'])->name('admin.tickets.update');
    Route::get('/stats', [AdminController::class, 'stats'])->name('admin.stats');
    // Sales analytics API
    Route::get('/sales/monthly', [AdminController::class, 'monthlySales'])->name('admin.sales.monthly');
    Route::get('/sales/yearly', [AdminController::class, 'yearlySales'])->name('admin.sales.yearly');
    
    // KPI Settings
    Route::post('/kpi/update', [AdminController::class, 'updateKpiSettings'])->name('admin.kpi.update');
    
    // Forecast Data
    Route::get('/forecast/data', [AdminController::class, 'getForecastData'])->name('admin.forecast.data');
    
    // XLSX Export routes
    Route::get('/export/monthly-xlsx', [AdminController::class, 'exportMonthlyXlsx'])->name('admin.export.monthly');
    Route::get('/export/yearly-xlsx', [AdminController::class, 'exportYearlyXlsx'])->name('admin.export.yearly');
    Route::get('/export/forecast-xlsx', [AdminController::class, 'exportForecastXlsx'])->name('admin.export.forecast');
    
    // Bookings & Payment History
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings.index');
    Route::get('/bookings/{id}', [AdminController::class, 'bookingDetail'])->name('admin.bookings.detail');
    
    // Event management routes
    Route::resource('events', App\Http\Controllers\Admin\EventController::class, [
        'as' => 'admin'
    ]);

    // Settings routes - Unified
    Route::prefix('settings')->group(function () {
        // Main settings page
        Route::get('/', [App\Http\Controllers\Admin\SettingsController::class, 'index'])
            ->name('admin.settings.index');
        Route::put('/prices', [App\Http\Controllers\Admin\SettingsController::class, 'updatePrices'])
            ->name('admin.settings.update-prices');
        Route::put('/operational', [App\Http\Controllers\Admin\SettingsController::class, 'updateOperational'])
            ->name('admin.settings.update-operational');
        Route::put('/change-password', [App\Http\Controllers\AdminController::class, 'changePassword'])
            ->name('admin.settings.change-password');
        Route::put('/change-username', [App\Http\Controllers\AdminController::class, 'changeUsername'])
            ->name('admin.settings.change-username');
        
        // All price history page
        Route::get('/all-price-history', [App\Http\Controllers\Admin\SettingsController::class, 'allPriceHistory'])
            ->name('admin.settings.all-price-history');
        
        // Legacy routes (kept for backwards compatibility if needed)
        Route::resource('ticket-categories', App\Http\Controllers\Admin\TicketCategoryController::class, [
            'as' => 'admin.settings'
        ]);
        Route::get('ticket-categories/{ticketCategory}/history', [App\Http\Controllers\Admin\TicketCategoryController::class, 'priceHistory'])
            ->name('admin.settings.ticket-categories.history');
        
        Route::get('operational', [App\Http\Controllers\Admin\OperationalSettingController::class, 'index'])
            ->name('admin.settings.operational.index');
        Route::put('operational-old', [App\Http\Controllers\Admin\OperationalSettingController::class, 'update'])
            ->name('admin.settings.operational.update-old');
    });
    
    // Special Tickets Admin routes
    Route::prefix('special-tickets')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SpecialTicketAdminController::class, 'index'])
            ->name('admin.special-tickets.index');
        Route::get('/{id}', [App\Http\Controllers\Admin\SpecialTicketAdminController::class, 'show'])
            ->name('admin.special-tickets.show');
        Route::post('/{id}/approve', [App\Http\Controllers\Admin\SpecialTicketAdminController::class, 'approve'])
            ->name('admin.special-tickets.approve');
        Route::post('/{id}/reject', [App\Http\Controllers\Admin\SpecialTicketAdminController::class, 'reject'])
            ->name('admin.special-tickets.reject');
    });
    }); // End of auth:admin middleware group
});
