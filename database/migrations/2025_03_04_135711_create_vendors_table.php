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
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('vendor_id');
            $table->unsignedBigInteger('company_id');
            $table->string('vendor_name');
            $table->string('category')->nullable();
            $table->text('description');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email')->nullable();
            $table->text('address');
            $table->text('tamap');
            $table->text('agency')->default('No');
            $table->string('country_code');
            $table->string('vendor_code', 4)->default('NULL');
            $table->integer('industry_id')->default(31);
            $table->json('products')->default('[]');
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
        Schema::dropIfExists('vendors');
    }
};
