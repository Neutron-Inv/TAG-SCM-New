<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role');
            $table->string('password');
            $table->string('user_activation_code');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->enum('status',['-1','0','1','2','3','4','5'])->default('1');
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
        Schema::dropIfExists('users');
    }
}
