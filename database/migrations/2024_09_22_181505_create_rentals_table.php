<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');  // Foreign key to books table
            $table->unsignedBigInteger('renter_id');  // Foreign key to users table (renter)
            $table->date('rented_at');
            $table->date('due_date');
            $table->date('returned_at')->nullable();
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['rented', 'returned', 'overdue'])->default('rented');  // Rental status
            $table->timestamps();
    
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('renter_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
    
};
