<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
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
            $table->unsignedBigInteger('company_id')->references('company_id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('industry_id')->references('industry_id')->on('industries')->onDelete('cascade');
            $table->string('vendor_name');
            $table->string('category')->nullable();
            $table->string('description');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->text('address');
            $table->text('tamap');
            $table->string('country_code');
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
        Schema::dropIfExists('vendors');
    }
}
