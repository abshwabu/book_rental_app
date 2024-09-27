<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class OwnerController extends Controller
{
    public function index(Request $request)
{
    $query = Book::where('owner_id', Auth::id());

    // Apply filtering
    if ($request->has('category')) {
        $query->where('category', $request->input('category'));
    }

    if ($request->has('search')) {
        $query->where('title', 'like', '%' . $request->input('search') . '%');
    }

    // Apply sorting
    if ($request->has('sort_by')) {
        $sortField = $request->input('sort_by');
        $query->orderBy($sortField, 'asc');
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
