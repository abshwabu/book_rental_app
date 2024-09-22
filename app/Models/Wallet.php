<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['owner_id', 'balance'];

    // A wallet belongs to a user (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
