<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_book', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('conservation_state_id');
            $table->string('comments')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('selling_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('on_sale_date')->nullable();
            $table->date('sold_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->constrained()->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('conservation_state_id')->references('id')->on('conservation_states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_book');
    }
};
