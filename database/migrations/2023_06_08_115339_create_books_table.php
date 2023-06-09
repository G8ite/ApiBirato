<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('parution_date')->nullable();
            $table->boolean('validated')->default(false);
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('book_cover_id')->nullable();
            $table->unsignedBigInteger('paper_type_id')->nullable();
            $table->unsignedBigInteger('format_id')->nullable();
            $table->unsignedBigInteger('isbn_code_id')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->constrained('authors');
            $table->foreign('book_cover_id')->references('id')->on('book_covers')->constrained('authors');
            $table->foreign('paper_type_id')->references('id')->on('paper_types')->constrained('authors');
            $table->foreign('format_id')->references('id')->on('formats')->constrained('authors');
            $table->foreign('isbn_code_id')->references('id')->on('isbn_codes')->constrained('authors');
            $table->foreign('editor_id')->references('id')->on('editors')->constrained('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
