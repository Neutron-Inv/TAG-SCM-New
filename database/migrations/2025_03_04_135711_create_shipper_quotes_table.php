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
        Schema::create('shipper_quotes', function (Blueprint $table) {
            $table->bigIncrements('quote_id');
            $table->unsignedBigInteger('shipper_id');
            $table->unsignedBigInteger('rfq_id');
            $table->string('soncap_charges');
            $table->string('customs_duty');
            $table->string('clearing_and_documentation');
            $table->string('trucking_cost');
            $table->string('status');
            $table->string('bmi_charges');
            $table->string('mode');
            $table->string('currency', 3)->default('NGN');
            $table->timestamps();
            $table->softDeletes();
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
};
