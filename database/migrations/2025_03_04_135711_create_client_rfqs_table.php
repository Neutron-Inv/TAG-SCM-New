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
        Schema::create('client_rfqs', function (Blueprint $table) {
            $table->bigIncrements('rfq_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('employee_id');
            $table->string('refrence_no')->unique('reference key unique');
            $table->dateTime('rfq_date');
            $table->string('rfq_number');
            $table->text('description');
            $table->string('product');
            $table->integer('is_lumpsum')->default(0);
            $table->string('lumpsum', 255)->nullable();
            $table->string('value_of_quote_usd')->default('0');
            $table->string('value_of_quote_ngn')->default('0');
            $table->string('contract_po_value_usd')->default('0');
            $table->integer('contract_po_value_ngn')->default(0);
            $table->string('total_quote', 100)->default('0');
            $table->string('incoterm', 100)->nullable();
            $table->string('supplier_quote_usd')->default('0');
            $table->string('freight_charges')->default('0');
            $table->string('local_delivery')->default('0');
            $table->string('fund_transfer')->default('0');
            $table->string('cost_of_funds')->default('0');
            $table->string('wht')->default('0');
            $table->string('ncd')->default('0');
            $table->string('other_cost')->default('0');
            $table->string('net_value')->default('0');
            $table->string('net_percentage')->default('0');
            $table->string('total_weight');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('shipper_id');
            $table->string('delivery_due_date');
            $table->text('note');
            $table->string('status');
            $table->timestamps();
            $table->string('rfq_acknowledge')->nullable();
            $table->string('percent_margin')->default('0');
            $table->string('percent_net', 100)->nullable()->default('0');
            $table->string('supplier_date')->nullable();
            $table->string('shipper_mail')->nullable();
            $table->string('shipper_submission_date')->nullable();
            $table->string('transport_mode')->nullable();
            $table->string('estimated_package_weight')->nullable();
            $table->string('estimated_package_dimension')->nullable();
            $table->string('hs_codes')->nullable();
            $table->string('certificates_offered')->nullable();
            $table->string('estimated_delivery_time')->nullable();
            $table->string('delivery_location')->nullable();
            $table->text('payment_term')->nullable();
            $table->string('validity')->nullable();
            $table->text('technical_note')->nullable();
            $table->integer('vendor_id')->default(1);
            $table->string('oversized', 4);
            $table->json('supplier_cof')->nullable();
            $table->json('logistics_cof')->nullable();
            $table->json('others_cof')->nullable();
            $table->string('percent_supplier', 20)->nullable()->default('0');
            $table->string('intrest_rate', 20)->default('0');
            $table->string('duration', 20)->default('0');
            $table->string('percent_supplier_1', 20)->nullable();
            $table->string('intrest_rate_1', 20)->nullable();
            $table->string('duration_1', 20)->nullable();
            $table->string('percent_supplier_2', 20)->nullable();
            $table->string('intrest_rate_2', 20)->nullable();
            $table->string('duration_2', 20)->nullable();
            $table->string('percent_logistics', 20)->nullable()->default('0');
            $table->string('intrest_logistics', 20)->nullable()->default('0');
            $table->string('duration_logistics', 20)->default('0');
            $table->string('percent_logistics_1', 20)->nullable();
            $table->string('intrest_logistics_1', 20)->nullable();
            $table->string('duration_logistics_1', 20)->nullable();
            $table->string('percent_logistics_2', 20)->nullable();
            $table->string('intrest_logistics_2', 20)->nullable();
            $table->string('duration_logistics_2', 20)->nullable();
            $table->json('misc_cost_supplier')->nullable();
            $table->json('misc_cost_logistics')->nullable();
            $table->json('misc_cost_others')->nullable();
            $table->string('online_submission', 4)->default('\'\'NO\'\'');
            $table->string('fund_transfer_charge', 10)->default('0');
            $table->string('vat_transfer_charge', 10)->default('0');
            $table->string('offshore_charges', 10)->default('0');
            $table->string('swift_charges', 10)->default('0');
            $table->string('currency', 4)->nullable();
            $table->softDeletes();
            $table->string('send_image', 3)->default('NO');
            $table->string('shipper_currency', 3)->default('NGN');
            $table->text('freight_cost_option')->default('No');
            $table->text('end_user')->nullable();
            $table->text('clearing_agent')->nullable();
            $table->string('short_code');
            $table->string('mark_up', 99)->default('0');
            $table->integer('auto_calculate')->default(0);
            $table->integer('ncd_others')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_rfqs');
    }
};
