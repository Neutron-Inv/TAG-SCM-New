<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientRfqsTable extends Migration
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
            $table->unsignedBigInteger('company_id')->references('company_id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->references('client_id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('employee_id')->references('employee_id')->on('employers')->onDelete('cascade');
            $table->string('refrence_no');
            $table->string('rfq_date');
            $table->string('rfq_number');
            $table->string('description');
            $table->string('product');
            $table->string('value_of_quote_usd');
            $table->string('value_of_quote_ngn');
            $table->string('contract_po_value_usd');
            $table->string('supplier_quote_usd');
            $table->string('percent_margin');
            $table->string('supplier_date')->nullable();
            $table->string('freight_charges');
            $table->string('local_delivery');
            $table->string('fund_transfer');
            $table->string('cost_of_funds');
            $table->string('wht');
            $table->string('ncd');
            $table->string('other_cost');
            $table->string('net_value');
            $table->string('net_percentage');
            $table->string('total_weight');
            $table->unsignedBigInteger('contact_id')->references('contact_id')->on('client_contacts')->onDelete('cascade');
            $table->unsignedBigInteger('shipper_id')->references('shipper_id')->on('shippers')->onDelete('cascade');
            $table->string('delivery_due_date');
            $table->string('note');
            $table->string('status');
            $table->string('rfq_acknowledge')->nullabled();
            $table->string('shipper_mail')->nullable();
            $table->string('shipper_submission_date')->nullable();
            $table->string('currency');
            $table->string('send_image');
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
        Schema::dropIfExists('client_rfqs');
    }
}
