<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Menambah kolom user_id
            $table->string('name');
            $table->text('description');
            $table->text('ingredients');
            $table->text('instructions');
            $table->string('image')->nullable();
            $table->timestamps();

            // Menambahkan indeks dan kunci asing untuk user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
