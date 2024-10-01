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
        $topBooks = Book::withCount('rentals')
                    ->orderBy('rentals_count', 'desc')
                    ->take(5)
                    ->get();

        // Most active renters (rentals per renter)
        $activeRenters = User::whereHas('rentals')
                    ->withCount('rentals')
                    ->orderBy('rentals_count', 'desc')
                    ->take(5)
                    ->get();
        
        $totalEarnings = Rental::sum('total_price');

        // Earnings by each owner
        $ownersEarnings = User::where('role', 'owner')->get()->map(function ($owner) {
            $owner->total_earnings = Rental::whereHas('book', function ($query) use ($owner) {
                $query->where('owner_id', $owner->id);
            })->sum('total_price');
            return $owner;
        });

        return view('admin.dashboard', compact('totalUsers', 'totalBooks', 'topBooks', 'activeRenters','totalEarnings', 'ownersEarnings'));
    }



    // Manage Users
    public function users()
    {
        $users = User::all();  // Fetch all users
        foreach ($users as $user) {
            if ($user->role === 'owner') {
                $user->total_earnings = Rental::whereHas('book', function ($query) use ($user) {
                    $query->where('owner_id', $user->id);
                })->sum('total_price');
            }
        }
        

        return view('admin.users', compact('users'));
    }

    // Edit Users
    public function editUser(User $user)
    {
        return view('admin.editUser', compact('user'));
    }
    public function updateUser(User $user, Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255', 'unique:users,email,'.$user->id],
            'phone_number' => 'numeric|nullable',
            'location' => 'nullable|string|max:255',
            'role' => 'required|string|in:renter,owner',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'phone_number' => $request->phone_number,
            'role' => $request->role
            ]);
        return redirect()->route('admin.users')->with('status', 'User updated successfully.');
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
        foreach ($books as $book) {
            if ($book->quantity < 1) {
                $book->status = 'unavailable';
            } else {
                $book->status = 'available';
            }
        }
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
        $user = User::where('role', 'owner');
        // Total earnings
        $totalEarnings = Rental::sum('total_price');
        
        // Earnings by each owner
        $ownersEarnings = Rental::where('owner_id', '=', $user->id)->get();
        
        return view('admin.dashboard', compact('totalEarnings', 'ownersEarnings'));
    }

}
