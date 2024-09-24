<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
class OwnerController extends Controller
{
    public function index(Request $request)
{
    if (Auth::user()->role !== 'owner') {
        return redirect()->route('home')->withErrors('Access denied.');
    }

    // Fetch books uploaded by the owner
    $query = Book::where('owner_id', auth()->id());

    // If a search term is provided, filter the books
    if ($request->has('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('category', 'like', '%' . $request->search . '%');
        });
    }

    $books = $query->get();
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
public function edit(Book $book)
{
    // Ensure the user is the owner of the book
    if ($book->owner_id !== auth()->id()) {
        return redirect()->route('owner.dashboard')->withErrors('You are not authorized to edit this book.');
    }

    return view('owner.books.edit', compact('book'));
}

public function update(Request $request, Book $book)
{
    // Ensure the user is the owner of the book
    if ($book->owner_id !== auth()->id()) {
        return redirect()->route('owner.dashboard')->withErrors('You are not authorized to update this book.');
    }

    // Validate the request
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'rental_price' => 'required|numeric',
        'status' => 'required|in:available,unavailable',
    ]);

    // Update the book details
    $book->update([
        'title' => $request->title,
        'author' => $request->author,
        'category' => $request->category,
        'quantity' => $request->quantity,
        'rental_price' => $request->rental_price,
        'status' => $request->status,
    ]);

    return redirect()->route('owner.dashboard')->with('status', 'Book updated successfully!');
}
public function destroy(Book $book)
{
    // Ensure the user is the owner of the book
    if ($book->owner_id !== auth()->id()) {
        return redirect()->route('owner.dashboard')->withErrors('You are not authorized to delete this book.');
    }

    // Delete the book
    $book->delete();

    return redirect()->route('owner.dashboard')->with('status', 'Book deleted successfully!');
}


}
