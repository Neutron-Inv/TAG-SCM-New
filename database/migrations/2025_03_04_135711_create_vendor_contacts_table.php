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
        Schema::create('vendor_contacts', function (Blueprint $table) {
            $table->bigIncrements('contact_id');
            $table->unsignedBigInteger('vendor_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('job_title');
            $table->string('office_tel');
            $table->string('mobile_tel');
            $table->string('email')->nullable();
            $table->string('email_other')->nullable();
            $table->text('address');
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->string('country_code');
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
        Schema::dropIfExists('vendor_contacts');
    }
};
