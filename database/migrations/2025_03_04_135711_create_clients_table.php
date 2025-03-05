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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('client_id');
            $table->unsignedBigInteger('company_id');
            $table->string('client_name');
            $table->text('address');
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->string('country_code');
            $table->string('phone');
            $table->string('email');
            $table->string('short_code')->nullable();
            $table->integer('transfer')->default(0);
            $table->string('company_vendor_code', 20)->nullable()->default('NULL');
            $table->text('login_url');
            $table->text('vendor_username');
            $table->text('vendor_password');
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
        Schema::dropIfExists('clients');
    }
};
