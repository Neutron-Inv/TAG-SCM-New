<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryLocationToClientRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_rfqs', function (Blueprint $table) {
            $table->string('delivery_location')->nullable();
            $table->string('validity')->nullable();
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
            $table->dropColumn(['delivery_location', 'validity']);
        });
    }
}
