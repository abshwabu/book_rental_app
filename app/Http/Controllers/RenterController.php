<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class RenterController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'renter') {
            return redirect()->route('home')->withErrors('Access denied.');
        }
    
        // Fetch available books for rent
        $books = Book::where('status', 'available')->get();
        return view('renter.dashboard', compact('books'));
    }
    
}
