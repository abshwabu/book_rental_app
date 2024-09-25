<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rental;
use Illuminate\Container\Attributes\Auth;



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
    $rental = new \App\Models\Rental();
    $rental->book_id = $book->id;
    $rental->renter_id = auth()->id();
    $rental->rented_at = now();
    $rental->due_date = $dueDate;
    $rental->total_price = $totalPrice;  // Set the due date 2 weeks later
    $rental->save();

    // Decrease the quantity of the book
    $book->quantity -= 1;
    $book->save();
    $admin = \App\Models\User::where('role', 'admin')->first();
    $admin->notify(new \App\Notifications\NewRentalNotification($rental));


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
}
