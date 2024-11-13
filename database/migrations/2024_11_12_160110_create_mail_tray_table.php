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
        Schema::create('mail_tray', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rfq_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('mail_id');
            $table->string('subject');
            $table->string('body');
            $table->string('recipient_email')->nullable();
            $table->string('sent_from')->nullable();
            $table->json('cc_email');
            $table->dateTime('date_received')->nullable();
            $table->dateTime('date_sent')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable();
            $table->timestamps();

            $table->foreign('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->foreign('vendor_id')->references('vendor_id')->on('vendors')->onDelete('cascade');
            $table->foreign('contact_id')->references('contact_id')->on('vendor_contacts')->onDelete( 'set null');
            $table->foreign('sent_by')->references('user_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_tray');
    }
};
