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
        Schema::create('pricing_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rfq_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('contact_id');
            $table->json('line_items');
            $table->string('conformity')->nullable();
            $table->string('total_quote')->nullable();
            $table->string('reliability')->nullable();
            $table->string('pricing')->nullable();
            $table->string('response_time')->nullable();
            $table->string('communication')->nullable();
            $table->string('mail_id');
            $table->string('status');
            $table->unsignedBigInteger('rated_by')->nullable();
            $table->timestamps();

            $table->foreign('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade');
            $table->foreign('contact_id')->references('contact_id')->on('vendor_contacts')->onDelete('cascade');
            $table->foreign('rated_by')->references('user_id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_history');
    }
};
