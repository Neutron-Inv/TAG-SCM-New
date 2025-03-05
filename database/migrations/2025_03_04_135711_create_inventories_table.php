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
        Schema::create('inventories', function (Blueprint $table) {
            $table->integer('inventory_id', true);
            $table->text('material_number');
            $table->text('short_description');
            $table->text('complete_description');
            $table->text('oem');
            $table->text('oem_part_number');
            $table->text('storage_location');
            $table->text('quantity_location');
            $table->text('material_condition');
            $table->text('preservations_required');
            $table->text('recommended_changes');
            $table->integer('warehouse_id');
            $table->text('approved_by');
            $table->string('user_email', 199);
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->text('updated_at')->nullable();
            $table->text('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
