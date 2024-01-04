<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipperQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipper_quotes', function (Blueprint $table) {
            $table->bigIncrements('quote_id');
            $table->unsignedBigInteger('shipper_id')->references('shipper_id')->on('shippers')->onDelete('cascade');
            $table->unsignedBigInteger('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->string('soncap_charges');
            $table->string('customs_duty');
            $table->string('clearing_and_documentation');
            $table->string('trucking_cost');
            $table->string('status');
            $table->string('bmi_charges');
            $table->string('mode');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipper_quotes');
    }
}
