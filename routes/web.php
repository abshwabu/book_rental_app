<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');
// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('status', 'Logged out successfully.');
})->name('logout')->middleware('auth');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    // Add this route for creating a new book
    Route::get('/owner/books/create', [OwnerController::class, 'create'])->name('owner.books.create');
    Route::post('/owner/books', [OwnerController::class, 'store'])->name('owner.books.store');
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/renter/dashboard', [RenterController::class, 'index'])->name('renter.dashboard');
});
