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
        Schema::create('rfq_numbers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('numbers', 255);
            $table->string('rfq_number', 255)->default('RFQ');
            $table->string('rfq', 255);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfq_numbers');
    }
};
