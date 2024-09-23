<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;


class OwnerController extends Controller
{
    public function index()
    {
        // Fetch all books uploaded by the authenticated user
        if (auth()) {
            $books = auth()->books;
        } else {
            // Handle the case when the user is not authenticated
            return redirect('/'); // or show an error
        }
        

        return view('owner.dashboard', compact('books'));
    }
}
