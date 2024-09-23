<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RenterController;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/renter/dashboard', [RenterController::class, 'index'])->name('renter.dashboard');
});
