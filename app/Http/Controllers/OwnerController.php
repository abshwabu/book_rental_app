<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
class OwnerController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Fetch all books uploaded by the authenticated user
            $books = Auth::user()->books;  // Ensure the books relationship is defined in the User model
        } else {
            // Redirect to login if the user is not authenticated
            return redirect()->route('login')->withErrors('You need to be logged in to access the dashboard.');
        }

        // Return the dashboard view with the list of books
        return view('owner.dashboard', compact('books'));
    }
    public function create()
    {
        return view('owner.books.create'); // Ensure this view exists
    }
    public function store(Request $request)
{
    // Validate all inputs
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'category' => 'required|string|max:255',  // Add validation for category
        'quantity' => 'required|integer|min:1',  // Validate quantity as an integer greater than or equal to 1
        'rental_price' => 'required|numeric',  // Ensure rental price is a number
        'status' => 'required|in:available,unavailable',  // Validate the status as one of the enum values
    ]);

    // Create a new book and associate it with the authenticated user
    $book = new Book([
        'title' => $request->title,
        'author' => $request->author,
        'category' => $request->category,
        'quantity' => $request->quantity,  // Add the quantity field
        'rental_price' => $request->rental_price,
        'status' => $request->status,  // Add status from the select input
    ]);

    auth()->user()->books()->save($book);

    // Redirect to the dashboard with a success message
    return redirect()->route('owner.dashboard')->with('status', 'Book added successfully!');
}


}
