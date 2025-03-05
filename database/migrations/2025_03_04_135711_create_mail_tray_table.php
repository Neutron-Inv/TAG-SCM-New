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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rfq_id')->index('mail_tray_rfq_id_foreign');
            $table->unsignedBigInteger('vendor_id')->index('mail_tray_vendor_id_foreign');
            $table->unsignedBigInteger('contact_id')->nullable()->index('mail_tray_contact_id_foreign');
            $table->string('mail_id');
            $table->string('subject');
            $table->binary('body');
            $table->string('recipient_email')->nullable();
            $table->text('sent_from')->nullable();
            $table->json('cc_email');
            $table->dateTime('date_received')->nullable();
            $table->dateTime('date_sent')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable()->index('mail_tray_sent_by_foreign');
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('mail_tray');
    }
};
