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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rfq_id')->index('pricing_history_rfq_id_foreign');
            $table->unsignedBigInteger('vendor_id')->index('pricing_history_vendor_id_foreign');
            $table->unsignedBigInteger('contact_id')->index('pricing_history_contact_id_foreign');
            $table->json('line_items');
            $table->string('conformity')->nullable();
            $table->string('total_quote')->nullable();
            $table->string('accuracy')->nullable();
            $table->string('pricing')->nullable();
            $table->string('response_time')->nullable();
            $table->string('negotiation')->nullable();
            $table->string('rfq_code', 150)->nullable();
            $table->string('reference_number', 255)->nullable();
            $table->string('mail_id');
            $table->string('status');
            $table->unsignedBigInteger('rated_by')->nullable()->index('pricing_history_rated_by_foreign');
            $table->unsignedBigInteger('issued_by')->nullable()->index('pricing_history_issued_by_foreign');
            $table->timestamps();
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
