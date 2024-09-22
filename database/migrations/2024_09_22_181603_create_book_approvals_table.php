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
    Schema::create('book_approvals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('book_id');  // Foreign key to books table
        $table->unsignedBigInteger('admin_id');  // Foreign key to users table (admin who approved)
        $table->boolean('approved')->default(false);  // Whether the book is approved
        $table->timestamps();

        $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('book_approvals');
}

};
