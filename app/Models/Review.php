<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    // Allow these attributes to be mass-assigned
    protected $fillable = ['book_id', 'renter_id', 'review', 'rating'];

    // Review belongs to a book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Review belongs to a renter (user)
    public function renter()
    {
        return $this->belongsTo(User::class, 'renter_id');
    }
}
