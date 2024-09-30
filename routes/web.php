<?php

use App\Http\Controllers\OwnerController;
use App\Http\Controllers\RenterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

// Home route
Route::get('/', [RenterController::class, 'index'])->name('home');

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

// Owner routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
    // Add this route for creating a new book
    Route::get('/owner/books/create', [OwnerController::class, 'create'])->name('owner.books.create');
    Route::get('/owner/books', [OwnerController::class, 'books'])->name('owner.books.mybooks');
    Route::post('/owner/books', [OwnerController::class, 'store'])->name('owner.books.store');
    // Route to display the edit form
    Route::get('/owner/books/{book}/edit', [OwnerController::class, 'edit'])->name('owner.books.edit');
    
    // Route to handle the submission of the edit form
    Route::put('/owner/books/{book}', [OwnerController::class, 'update'])->name('owner.books.update');
    // Route to delete a book
    Route::delete('/owner/books/{book}', [OwnerController::class, 'destroy'])->name('owner.books.destroy');
    
    Route::get('/owner/report', [OwnerController::class, 'report'])->name('owner.report');

});

// Renter routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/renter/dashboard', [RenterController::class, 'index'])->name('renter.dashboard');
});

// Admin routes
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::put('/admin/users/{user}/activate', [AdminController::class, 'activateUser'])->name('admin.users.activate');
    Route::put('/admin/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');
    Route::get('/admin/books', [AdminController::class, 'books'])->name('admin.books');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/books/{book}', [AdminController::class, 'destroyBook'])->name('admin.books.destroy');
});

// Book rental route
Route::post('/books/{book}/rent', [RentalController::class, 'rent'])->name('books.rent')->middleware('auth:sanctum');
Route::get('/renter/books', [RentalController::class, 'index'])->name('renter.books');
Route::put('/rentals/{rental}/return', [RentalController::class, 'returnBook'])->name('rentals.return');
Route::post('/rentals/{rental}/extend', [RentalController::class, 'extendRental'])->name('rentals.extend');
Route::post('/renter/books/{book}/review', [RentalController::class, 'review'])->name('renter.books.review');

