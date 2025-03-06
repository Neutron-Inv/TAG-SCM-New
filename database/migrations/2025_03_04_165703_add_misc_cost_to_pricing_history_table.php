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
            $table->longText('lead_time')->nullable()->after('negotiation');
            $table->longText('delivery_time')->nullable()->after('lead_time'); 
            $table->longText('delivery_location')->nullable()->after('delivery_time');
            $table->longText('payment_term')->nullable()->after('delivery_location');
            $table->longText('misc_cost')->nullable()->after('reference_number'); 
            $table->longText('weight')->nullable()->after('misc_cost');;
            $table->longText('dimension')->nullable()->after('weight');; 
            $table->longText('hs_codes')->nullable()->after('dimension');; 
            $table->longText('general_terms')->nullable()->after('hs_codes');;
            $table->longText('notes_to_pricing')->nullable()->after('general_terms');; 
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
            $table->dropColumn('lead_time');
            $table->dropColumn('delivery_time');
            $table->dropColumn('delivery_location');
            $table->dropColumn('payment_term');
            $table->dropColumn('misc_cost');
            $table->dropColumn('weight');
            $table->dropColumn('dimension');
            $table->dropColumn('hs_codes');
            $table->dropColumn('general_terms');
            $table->dropColumn('notes_to_pricing');
        });
    }
};
