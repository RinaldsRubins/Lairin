<?php

use App\Http\Controllers\Api\V1\BookingApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('bookings', [BookingApiController::class, 'index'])->name('bookings.index');
    Route::post('bookings', [BookingApiController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [BookingApiController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking}/cancel', [BookingApiController::class, 'cancel'])->name('bookings.cancel');
});
