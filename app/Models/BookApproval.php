<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookApproval extends Model
{
    protected $fillable = ['book_id', 'admin_id', 'approved'];

    // The book that is being approved
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // The admin who approved the book
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
