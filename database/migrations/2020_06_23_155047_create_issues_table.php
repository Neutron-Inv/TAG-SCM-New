<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssuesTable extends Migration
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
            $table->unsignedBigInteger('company_id')->references('company_id')->on('companies')->onDelete('cascade');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->text('message');
            $table->enum('status',['-1','0','1','2','3','4','5','6','7','8'])->default('0');
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('assigned_to')->references('user_id')->on('users')->onDelete('cascade');
            $table->string('priority');
            $table->string('category');
            $table->timestamps();
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
        Schema::dropIfExists('issues');
    }
}
