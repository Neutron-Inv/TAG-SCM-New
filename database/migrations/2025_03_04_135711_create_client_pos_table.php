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
        Schema::create('client_pos', function (Blueprint $table) {
            $table->bigIncrements('po_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('rfq_id');
            $table->string('rfq_number');
            $table->string('status');
            $table->string('po_number');
            $table->text('product');
            $table->string('description');
            $table->date('po_date');
            $table->string('po_receipt_date');
            $table->date('supplier_issued_date')->nullable();
            $table->string('est_production_time')->nullable();
            $table->string('est_ddp_lead_time')->nullable();
            $table->date('delivery_due_date')->nullable();
            $table->string('est_delivery_date')->nullable();
            $table->string('delivery_location')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->string('currency', 50)->nullable();
            $table->string('total_quote', 200)->default('0');
            $table->string('po_value_foreign');
            $table->string('po_value_naira');
            $table->string('payment_terms')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->string('supplier_proforma_foreign')->nullable();
            $table->string('supplier_proforma_naira')->nullable();
            $table->string('shipping_cost')->nullable();
            $table->string('po_issued_to_supplier')->nullable();
            $table->string('payment_details_received')->nullable();
            $table->string('payment_made')->nullable();
            $table->string('payment_confirmed')->nullable();
            $table->string('work_order')->nullable();
            $table->string('shipment_initiated')->nullable();
            $table->string('shipment_arrived')->nullable();
            $table->string('docs_to_shipper');
            $table->string('delivered_to_customer')->nullable();
            $table->string('delivery_note_submitted')->nullable();
            $table->string('customer_paid')->nullable();
            $table->string('payment_due');
            $table->longText('note');
            $table->string('status_2')->nullable();
            $table->text('ex_works_date')->nullable();
            $table->text('transport_mode')->nullable();
            $table->integer('shipping_reliability')->nullable()->default(0);
            $table->integer('shipping_on_time_delivery')->nullable();
            $table->integer('shipping_pricing')->nullable();
            $table->integer('shipping_communication')->nullable()->default(0);
            $table->text('shipping_rater')->nullable();
            $table->longText('shipping_comment')->nullable()->default('\'\'0\'\'');
            $table->integer('shipping_overall_rating')->nullable()->default(0);
            $table->integer('survey_sent')->default(0);
            $table->string('survey_sent_date', 35)->nullable();
            $table->boolean('survey_completed')->default(false);
            $table->date('survey_completion_date')->nullable();
            $table->unsignedBigInteger('contact_id');
            $table->timestamps();
            $table->softDeletes();
            $table->text('tag_comment')->default('Test Comment');
            $table->string('supplier_ref_number', 255)->nullable()->default('Null');
            $table->date('actual_delivery_date')->nullable();
            $table->string('timely_delivery', 4)->default('NO');
            $table->string('shipper_timely_delivery', 11)->default('YES');
            $table->integer('shipper_id');
            $table->text('delivery');
            $table->text('technical_notes');
            $table->text('hs_codes');
            $table->text('total_packaged_weight')->nullable();
            $table->text('estimated_packaged_dimensions')->nullable();
            $table->text('delivery_location_po')->default('NULL');
            $table->text('hs_codes_po')->nullable()->default('NULL');
            $table->string('port_of_discharge', 199)->default('Lagos');
            $table->text('payment_terms_client')->default('NULL');
            $table->string('freight_charges_suplier', 199)->nullable()->default('0');
            $table->string('schedule', 50)->default('On Schedule');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_pos');
    }
};
