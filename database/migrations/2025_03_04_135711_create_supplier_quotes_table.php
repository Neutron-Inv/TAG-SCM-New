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
        Schema::create('supplier_quotes', function (Blueprint $table) {
            $table->bigIncrements('supplier_quote_id');
            $table->string('status');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('rfq_id');
            $table->unsignedBigInteger('line_id');
            $table->string('quantity');
            $table->string('price');
            $table->string('weight');
            $table->string('dimension');
            $table->text('note')->nullable();
            $table->string('oversize');
            $table->string('currency');
            $table->text('location');
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
        Schema::dropIfExists('supplier_quotes');
    }
};
