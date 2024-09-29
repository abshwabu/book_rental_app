<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Rental;
class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $owner = Auth::user();

        // Calculate total earnings
        $totalEarnings = Rental::whereHas('book', function ($query) use ($owner) {
            $query->where('owner_id', $owner->id);
        })->sum('rental_price');

        // Count total rentals of the owner's books
        $totalRentals = Rental::whereHas('book', function ($query) use ($owner) {
            $query->where('owner_id', $owner->id);
        })->count();

        // Get all books of the owner
        $books = Book::where('owner_id', $owner->id)->get();

        return view('owner.dashboard', compact('totalEarnings', 'totalRentals', 'books'));
    }

    public function create()
    {
        if (Auth::user()->active) {
            return view('owner.books.create'); // Ensure this view exists
        } else {
            return redirect()->back()->withErrors('You cannot upload a book. Your account is deactivated.');
        }
        
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validate image
        ]);

        // Handle the file upload
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('cover_images', 'public');
        }

        // Create the book
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'rental_price' => $request->rental_price,
            'status' => $request->status,
            'owner_id' => auth()->id(),
            'cover_image' => $coverImagePath, // Store the image path
        ]);

        return redirect()->route('owner.dashboard')->with('status', 'Book added successfully.');
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
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // Handle the file upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $book->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        // Update other fields
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'rental_price' => $request->rental_price,
            'status' => $request->status,
        ]);

        return redirect()->route('owner.dashboard')->with('status', 'Book updated successfully.');
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
public function books()
{
    $books = Book::where('owner_id', auth()->id())->get();
    return view('owner.books.mybooks', compact('books'));
}
public function report()
    {
        // Fetch the rentals of the owner's books
        $rentals = \App\Models\Rental::whereIn('book_id', auth()->user()->books->pluck('id'))->get();

        return view('owner.report', compact('rentals'));
    }

}
