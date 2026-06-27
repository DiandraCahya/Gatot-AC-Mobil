<?php

use App\Livewire\Chat;
use App\Models\Jasa;
use App\Models\Rating;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\StrukGenerateController;
use App\Livewire\BackupBooking;

Route::get('/', function () {
    $ratings = Rating::all();
    $jasa = Jasa::all();
    return view('welcome', compact('ratings' , 'jasa'));
})->name('welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('payment/callback', [MidtransController::class, 'handleCallback'])->name('payment.callback');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');
    // Rute untuk user
    Route::get('/bookings/my-bookings', [BookingController::class, 'userBookings'])->name('bookings.user');
    Route::get('/bookings/{booking}/details', [BookingController::class, 'getDetailUser'])->name('bookings.details');
    Route::delete('/bookings/{id}/delete', [BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::get('Chat', Chat::class)->name('Chat');

    // Rute untuk rating
    Route::get('/ratings/create/{booking}', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

    // Payment
    Route::post('payment/token/{struk}', [MidtransController::class, 'getPaymentToken'])->name('payment.token');

    // Rute untuk detail struk
    Route::get('struk/generate/{struk}', [StrukGenerateController::class, 'generate'])->name('struk.generate');
    Route::get('/bookings/{booking}/struks', [StrukController::class, 'showuser'])->name('struk.showuser');

    // Rute untuk admin
    Route::middleware(['is_admin'])->group(function () {
        Route::get('/admin/bookings', [BookingController::class, 'adminBookings'])->name('bookings.admin');
        Route::get('/bookings/{booking}/detail', [BookingController::class, 'getDetail'])->name('bookings.detail');
        Route::put('/bookings/{id}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::get('/bookings/{id}/reject-modal', [BookingController::class, 'showRejectModal'])->name('bookings.reject-modal');
        Route::put('/bookings/{id}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

        //Rute untuk struk
        Route::get('/bookings/{booking}/struk/create', [StrukController::class, 'create'])->name('struk.create');
        Route::post('/struk/store', [StrukController::class, 'store'])->name('struk.store');
        Route::put('/struk/{struk}', [StrukController::class, 'update'])->name('struk.update');
        Route::get('/bookings/{booking}/struk', [StrukController::class, 'show'])->name('struk.show');

        // Rute untuk Jasa
        Route::get('/jasa/create', [JasaController::class, 'create'])->name('jasa.create');
        Route::post('/jasa', [JasaController::class, 'store'])->name('jasa.store');
        Route::get('/jasa/{jasa}/edit', [JasaController::class, 'edit'])->name('jasa.edit');
        Route::put('/jasa/{jasa}', [JasaController::class, 'update'])->name('jasa.update');
        Route::delete('/jasa/{jasa}', [JasaController::class, 'destroy'])->name('jasa.destroy');

        
    });
});
require __DIR__ . '/auth.php';
