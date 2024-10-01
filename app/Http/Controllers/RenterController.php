<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class RenterController extends Controller
{
    public function index()
    {
        // Ensure only renters can access this page
        

        // Fetch available books for rent
        $books = Book::where('status', 'available')->get(); // Fetching books with 'available' status
        foreach ($books as $book) {
            if ($book->quantity < 1) {
                $book->status = 'unavailable';
            } else {
                $book->status = 'available';
            }
        }
        return view('home', compact('books')); // Passing books to the view
    }
    // Handle application to become an owner
    public function applyToBecomeOwner(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'renter') {
            // Update user's role to indicate they have applied to become an owner
            $user->role = 'owner';  // Optional role to signify that the application is pending
            $user->active = false;
            $user->save();

            // Optionally, notify the admin here (via email or a notification system)

            return redirect()->back()->with('status', 'Your application to become an owner has been submitted.');
        }

        return redirect()->back()->withErrors('You are already an owner.');
    }
}
