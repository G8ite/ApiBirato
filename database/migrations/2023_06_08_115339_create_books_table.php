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
            $table->unsignedBigInteger('id_author');
            $table->unsignedBigInteger('id_book_cover')->nullable();
            $table->unsignedBigInteger('id_paper_type')->nullable();
            $table->unsignedBigInteger('id_format')->nullable();
            $table->unsignedBigInteger('id_isbn_code')->nullable();
            $table->unsignedBigInteger('id_editor')->nullable();
            $table->timestamps();

            $table->foreign('id_author')->references('id')->on('authors');
            $table->foreign('id_book_cover')->references('id')->on('book_covers');
            $table->foreign('id_paper_type')->references('id')->on('paper_types');
            $table->foreign('id_format')->references('id')->on('formats');
            $table->foreign('id_isbn_code')->references('id')->on('isbn_codes');
            $table->foreign('id_editor')->references('id')->on('editors');
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
