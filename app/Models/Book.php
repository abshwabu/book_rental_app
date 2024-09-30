<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['owner_id', 'title', 'author', 'category', 'quantity', 'rental_price', 'status','cover_image'];

    // A book belongs to a user (book owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // A book can have many rentals
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    // A book belongs to a category (optional if using categories)
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function ($book) {
            // Automatically set the status based on quantity
            if ($book->quantity < 1) {
                $book->status = 'unavailable';
            } else {
                $book->status = 'available';
            }
        });
    }
}
