<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_ratings', function (Blueprint $table) {
            $table->bigIncrements('rating_id');
            $table->integer('rfq_id');
            $table->integer('po_id');
            $table->unsignedBigInteger('client_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->string('reliability');
            $table->text('on_time_delivery');
            $table->string('pricing');
            $table->string('communication');
            $table->text('rater');
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
        Schema::dropIfExists('shipping_ratings');
    }
}
