<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntrestLogisticToClientRfqs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_rfqs', function (Blueprint $table) {
            $table->string('intrest_logistics')->nullable();
            $table->string('duration_logistics')->nullable();
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
