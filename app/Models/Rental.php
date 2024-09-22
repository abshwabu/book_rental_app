<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $fillable = ['book_id', 'renter_id', 'rented_at', 'due_date', 'returned_at', 'total_price', 'status'];

    // A rental belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // A rental belongs to a user (renter)
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }
}
