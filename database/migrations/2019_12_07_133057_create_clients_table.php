<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
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
            $table->unsignedBigInteger('company_id')->references('company_id')->on('industries')->onDelete('cascade');
            $table->string('client_name');
            $table->text('address');
            $table->text('state');
            $table->text('city');
            $table->string('country_code');
            $table->string('phone');
            $table->string('email');
            $table->string('short_code');
            $table->integer('transfer');
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
        Schema::dropIfExists('clients');
    }
}
