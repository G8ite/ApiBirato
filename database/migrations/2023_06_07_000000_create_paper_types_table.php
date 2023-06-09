<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperTypesTable extends Migration
{
    public function up()
    {
        Schema::create('paper_types', function (Blueprint $table) {
            $table->id();
            $table->string('paper_type_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paper_types');
    }
}
