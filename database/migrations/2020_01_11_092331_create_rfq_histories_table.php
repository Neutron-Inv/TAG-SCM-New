<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_histories', function (Blueprint $table) {
            $table->bigIncrements('history_id');
            $table->unsignedBigInteger('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->string('action');
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
        Schema::dropIfExists('rfq_histories');
    }
}
