<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPopularityColumnsToRecipesTable extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('views')->default(0);
            $table->decimal('rating', 2, 1)->default(0);
        });
    }

    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn(['views', 'rating']);
        });
    }
}
