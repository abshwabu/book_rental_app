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
    Schema::create('wallets', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('owner_id');  // Foreign key to users table (book owner)
        $table->decimal('balance', 10, 2)->default(0.00);  // Owner's balance
        $table->timestamps();

        $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('wallets');
}

};
