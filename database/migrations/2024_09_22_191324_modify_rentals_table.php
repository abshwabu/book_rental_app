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
    Schema::table('rentals', function (Blueprint $table) {
        // Only add columns that don't already exist
        if (!Schema::hasColumn('rentals', 'renter_id')) {
            $table->unsignedBigInteger('renter_id');  // Foreign key to users table
        }

        if (!Schema::hasColumn('rentals', 'rented_at')) {
            $table->date('rented_at');
        }

        if (!Schema::hasColumn('rentals', 'due_date')) {
            $table->date('due_date');
        }

        if (!Schema::hasColumn('rentals', 'returned_at')) {
            $table->date('returned_at')->nullable();
        }

        if (!Schema::hasColumn('rentals', 'total_price')) {
            $table->decimal('total_price', 8, 2);
        }

        if (!Schema::hasColumn('rentals', 'status')) {
            $table->enum('status', ['rented', 'returned', 'overdue'])->default('rented');
        }

        // Foreign key constraints (only if they haven't been added)
        if (!Schema::hasColumn('rentals', 'book_id')) {
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        }

        if (!Schema::hasColumn('rentals', 'renter_id')) {
            $table->foreign('renter_id')->references('id')->on('users')->onDelete('cascade');
        }
    });
}

public function down()
{
    Schema::table('rentals', function (Blueprint $table) {
        $table->dropForeign(['book_id']);
        $table->dropForeign(['renter_id']);
        $table->dropColumn(['rented_at', 'due_date', 'returned_at', 'total_price', 'status']);
    });
}

};
