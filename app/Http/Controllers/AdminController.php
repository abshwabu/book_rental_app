<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Rental;
class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        // Total users and books
        $totalUsers = User::count();
        $totalBooks = Book::count();

        // Top rented books
        $topBooks = \App\Models\Book::withCount('rentals')
                    ->orderBy('rentals_count', 'desc')
                    ->take(5)
                    ->get();

        // Most active renters (rentals per renter)
        $activeRenters = \App\Models\User::whereHas('rentals')
                    ->withCount('rentals')
                    ->orderBy('rentals_count', 'desc')
                    ->take(5)
                    ->get();
        
        $totalEarnings = Rental::sum('total_price');

        // Earnings by each owner
        $ownersEarnings = User::where('role', 'owner')
            ->withSum('books as total_earnings', 'total_price')
            ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalBooks', 'topBooks', 'activeRenters','totalEarnings', 'ownersEarnings'));
    }



    // Manage Users
    public function users()
    {
        $users = User::all();  // Fetch all users
        $ownersEarnings = User::where('role', 'owner')
            ->withSum('books as total_earnings', 'rental_price')
            ->get();

        return view('admin.users', compact('users', 'ownersEarnings'));
    }

    // Delete a user
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('status', 'User deleted successfully.');
    }

    // Manage all books
    public function books()
    {
        $books = Book::all();  // Fetch all books
        return view('admin.books', compact('books'));
    }

    // Delete a book
    public function destroyBook(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books')->with('status', 'Book deleted successfully.');
    }
    public function activateUser(User $user)
    {
        $user->active = true;
        $user->save();
        
        return redirect()->route('admin.users')->with('status', 'User activated successfully.');
    }

    public function deactivateUser(User $user)
    {
        $user->active = false;
        $user->save();
        
        return redirect()->route('admin.users')->with('status', 'User deactivated successfully.');
    }
    public function totalEarnings()
    {
        // Total earnings
        $totalEarnings = Rental::sum('total_price');
        
        // Earnings by each owner
        $ownersEarnings = User::where('role', 'owner')
            ->withSum('books as total_earnings', 'rental_price')
            ->get();
        
        return view('admin.dashboard', compact('totalEarnings', 'ownersEarnings'));
    }

}
