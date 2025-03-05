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
        Schema::create('line_items', function (Blueprint $table) {
            $table->bigIncrements('line_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('rfq_id');
            $table->integer('item_serialno')->default(1);
            $table->string('item_name');
            $table->string('item_number');
            $table->string('oem')->nullable();
            $table->string('uom')->default('1');
            $table->string('quantity')->default('1');
            $table->string('unit_price')->default('0');
            $table->string('total_price')->default('0');
            $table->string('unit_quote')->default('0');
            $table->string('total_quote')->default('0');
            $table->string('unit_margin')->default('0');
            $table->string('total_margin')->default('0');
            $table->string('unit_frieght')->default('0');
            $table->string('total_frieght')->default('0');
            $table->string('unit_cost')->default('0');
            $table->string('total_cost')->default('0');
            $table->string('unit_cost_naira')->default('0');
            $table->string('total_cost_naira')->default('0');
            $table->text('item_description')->nullable();
            $table->longText('alternate_offer')->nullable();
            $table->string('mesc_code', 20)->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->integer('active')->nullable();
            $table->unsignedBigInteger('vendor_id')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['rfq_id', 'item_serialno'], 'Unique SerialNum');
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
};
