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
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('owner_id');  // Foreign key to users table (book owner)
        $table->string('title');
        $table->string('author');
        $table->string('category');  // You can create a categories table later if needed
        $table->integer('quantity');  // Number of available copies
        $table->decimal('rental_price', 8, 2);  // Price for renting the book
        $table->enum('status', ['available', 'unavailable'])->default('available');  // Available if not rented
        $table->timestamps();
        $table->unsignedBigInteger('category_id')->nullable();

        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('books');
}

};
