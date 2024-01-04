<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPosTable extends Migration
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
            $table->unsignedBigInteger('company_id')->references('company_id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('rfq_id')->references('rfq_id')->on('client_rfqs')->onDelete('cascade');
            $table->string('rfq_number');
            $table->string('status');
            $table->string('po_number');
            $table->string('description');

            $table->string('po_date');
            $table->string('po_receipt_date');
            $table->string('est_production_time');
            $table->string('est_ddp_lead_time');

            $table->string('delivery_due_date');
            $table->string('est_delivery_date');
            $table->string('delivery_location');
            $table->string('delivery_terms');

            $table->string('po_value_foreign');
            $table->string('po_value_naira');
            $table->string('payment_terms');
            // $table->unsignedBigInteger('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');

            $table->string('supplier_proforma_foreign');
            $table->string('supplier_proforma_naira');
            $table->string('shipping_cost');
            $table->string('po_issued_to_supplier');

            $table->string('payment_details_received');
            $table->string('payment_made');
            $table->string('payment_confirmed');
            $table->string('work_order');

            $table->string('shipment_initiated');
            $table->string('shipment_arrived');
            $table->string('docs_to_shipper');
            $table->string('delivered_to_customer');

            $table->string('delivery_note_submitted');
            $table->string('customer_paid');
            $table->string('payment_due');
            $table->string('note');
            $table->string('status_2');
            $table->unsignedBigInteger('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('contact_id')->references('contact_id')->on('client_contacts')->onDelete('cascade');
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
        Schema::dropIfExists('client_pos');
    }
}
