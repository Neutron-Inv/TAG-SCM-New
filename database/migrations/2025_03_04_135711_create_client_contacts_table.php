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
        Schema::create('client_contacts', function (Blueprint $table) {
            $table->bigIncrements('contact_id');
            $table->unsignedBigInteger('client_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('job_title');
            $table->string('office_tel');
            $table->string('mobile_tel');
            $table->string('email');
            $table->string('email_other');
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
        Schema::dropIfExists('client_contacts');
    }
};
