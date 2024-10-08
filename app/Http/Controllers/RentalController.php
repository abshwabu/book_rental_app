<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Container\Attributes\Auth;
use App\Models\User;



class RentalController extends Controller
{
    public function rent(Book $book)
    {
        if ($book->quantity <= 0) {
            return redirect()->back()->withErrors('This book is currently unavailable.');
        }
        $rentalDuration = 2;  // 2 weeks
        $dueDate = now()->addWeeks($rentalDuration);

        // Calculate the total price (rental price * rental duration)
        $totalPrice = $book->rental_price * $rentalDuration;
        
        // Create a new rental
        Rental::create([
            'book_id' => $book->id,
            'renter_id' => auth()->id(),
            'rented_at' => now(),
            'due_date' => now()->addDays(14), // Example 2-week rental
            'rental_price' => $book->rental_price,
            'total_price' => $totalPrice,
            'status' => 'Rented' // This is the default value
        ]);

        // Decrease the quantity of the book
        $book->quantity -= 1;
        $book->save();
        $admin = User::where('role', 'admin')->first();


        return redirect()->route('renter.dashboard')->with('status', 'Book rented successfully.');
    }
    public function index()
    {
        // Get the books rented by the logged-in renter
        $rentals = Rental::with('book')  // Assuming there's a relationship to the Book model
                        ->where('renter_id', auth()->id())
                        ->get();
        
        return view('renter.books', compact('rentals'));
    }
    public function returnBook(Rental $rental)
    {
        // Set the book status back to available and increase its quantity
        $book = $rental->book;
        $book->quantity += 1;
        $book->status = 'available';
        $book->save();

        $rental->status = 'Returned';
        $rental->save();

        return redirect()->route('renter.books')->with('status', 'Book returned successfully.');
    }

    public function extendRental(Rental $rental)
    {
        // Extend the rental due date by 7 days
        $rental->due_date = $rental->due_date->addDays(7);
        $rental->save();

        return redirect()->route('renter.books')->with('status', 'Rental period extended.');
    }
    public function review(Request $request, Book $book)
    {
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        \App\Models\Review::create([
            'book_id' => $book->id,
            'renter_id' => auth()->id(),
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('renter.books')->with('status', 'Review submitted successfully.');
    }
    



}
