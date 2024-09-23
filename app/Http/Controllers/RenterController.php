<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class RenterController extends Controller
{
    public function index()
    {
        // Fetch all books that are available for rent
        $books = Book::where('status', 'available')->get();

        return view('renter.dashboard', compact('books'));
    }
}
