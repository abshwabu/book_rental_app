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
}
