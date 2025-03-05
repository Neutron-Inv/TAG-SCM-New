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
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable()->index('company_id');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->text('message');
            $table->enum('status', ['-1', '0', '1', '2', '3', '4', '5', '6', '7', '8'])->default('0');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('assigned_to');
            $table->string('priority');
            $table->string('category');
            $table->dateTime('completion_time');
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
        Schema::dropIfExists('issues');
    }
};
