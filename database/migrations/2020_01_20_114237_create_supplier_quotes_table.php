<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_quotes', function (Blueprint $table) {
            $table->bigIncrements('supplier_quote_id');
            $table->string('status');
            $table->unsignedBigInteger('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade');
            $table->unsignedBigInteger('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->unsignedBigInteger('line_id')->references('line_id')->on('line_items')->onDelete('cascade');
            $table->string('quantity');
            $table->string('price');
            $table->string("weight");
            $table->string("dimension");
            $table->text("note")->nullable();
            $table->string("oversize");
            $table->string('currency');
            $table->text('location');
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
        Schema::dropIfExists('supplier_quotes');
    }
}
