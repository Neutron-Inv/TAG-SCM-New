<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_items', function (Blueprint $table) {
            $table->bigIncrements('line_id');
            $table->unsignedBigInteger('client_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->string('item_name');
            $table->string('item_number');
            $table->string('oem')->nullable();
            $table->string('uom');
            $table->string('quantity');
            $table->string('unit_price');
            $table->string('total_price');
            $table->string('unit_quote');
            $table->string('total_quote');
            $table->string('unit_margin');
            $table->string('total_margin');
            $table->string('unit_frieght');
            $table->string('total_frieght');
            $table->string('unit_cost');
            $table->string('total_cost');
            $table->string('unit_cost_naira');
            $table->string('total_cost_naira');
            $table->string('item_description');
            $table->unsignedBigInteger('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade');
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
        Schema::dropIfExists('line_items');
    }
}
