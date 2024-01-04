<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOversizedToClientRfqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_rfqs', function (Blueprint $table) {
            $table->string('oversized')->nullable();
            $table->string('intrest_rate')->nullable();
            $table->string('duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_rfqs', function (Blueprint $table) {
            //
        });
    }
}
