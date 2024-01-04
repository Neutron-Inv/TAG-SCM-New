<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransportModeToClientRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_rfqs', function (Blueprint $table) {
            $table->string('transport_mode')->nullable();
            $table->string('estimated_package_weight')->nullable();
            $table->string('estimated_package_dimension')->nullable();
            $table->string('hs_codes')->nullable();
            $table->string('offer_certificates')->nullable();
            $table->string('estimated_delivery_time')->nullable();
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
             $table->dropColumn(['transport_mode', 'estimated_package_weight', 'estimated_package_dimension', 'hs_codes', 'offer_certificates', 'estimated_delivery_time']);
        });
    }
}
