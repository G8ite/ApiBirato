<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCoversTable extends Migration
{
    public function up()
    {
        Schema::create('book_covers', function (Blueprint $table) {
            $table->id();
            $table->string('book_cover_name')->notNullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_covers');
    }
}
