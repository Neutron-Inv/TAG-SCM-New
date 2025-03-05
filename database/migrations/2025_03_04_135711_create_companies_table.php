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
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('company_id');
            $table->integer('status');
            $table->unsignedBigInteger('industry_id');
            $table->string('company_name');
            $table->string('company_code');
            $table->text('address');
            $table->integer('lgaId');
            $table->string('contact');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('phone');
            $table->string('email');
            $table->text('webadd');
            $table->text('company_description');
            $table->integer('no_agents');
            $table->integer('no_cust');
            $table->integer('inactive');
            $table->integer('activation_count');
            $table->date('status_dt')->nullable();
            $table->string('lang_year')->nullable();
            $table->integer('servplan_allowed');
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
        Schema::dropIfExists('companies');
    }
};
