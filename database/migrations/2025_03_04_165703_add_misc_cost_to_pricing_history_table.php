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
        Schema::table('pricing_history', function (Blueprint $table) {
            $table->longText('misc_cost')->nullable()->after('reference_number'); // Change 'your_column_name' to the column after which you want to add this
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pricing_history', function (Blueprint $table) {
            $table->dropColumn('misc_cost');
        });
    }
};
