<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rfq_id');
            $table->string('reference_no');
            $table->unsignedBigInteger('vendor_id');
            $table->string('product');
            $table->text('description')->nullable();
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('rfq_id')->references('rfq_id')->on('client_rfqs'); // Assuming the RFQs table is named 'rfq'
            $table->foreign('vendor_id')->references('vendor_id')->on('vendors'); // Assuming the vendors table is named 'vendors'
        });
    }

    public function down()
    {
        Schema::dropIfExists('rfq_suppliers');
    }
}
