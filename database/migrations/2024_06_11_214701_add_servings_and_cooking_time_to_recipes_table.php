<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('servings')->after('category'); // Adjust the position as needed
            $table->integer('cooking_time')->after('servings');
        });
    }

    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('servings');
            $table->dropColumn('cooking_time');
        });
    }

};
