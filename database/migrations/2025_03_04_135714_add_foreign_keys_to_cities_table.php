<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign(['country_id'], 'cities_ibfk_2')->references(['id'])->on('countries');
            $table->foreign(['state_id'], 'cities_ibfk_1')->references(['id'])->on('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign('cities_ibfk_2');
            $table->dropForeign('cities_ibfk_1');
        });
    }
};
