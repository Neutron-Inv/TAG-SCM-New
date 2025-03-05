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
        Schema::table('mail_tray', function (Blueprint $table) {
            $table->foreign(['rfq_id'])->references(['rfq_id'])->on('client_rfqs')->onDelete('CASCADE');
            $table->foreign(['vendor_id'])->references(['vendor_id'])->on('vendors')->onDelete('CASCADE');
            $table->foreign(['contact_id'])->references(['contact_id'])->on('vendor_contacts')->onDelete('SET NULL');
            $table->foreign(['sent_by'])->references(['user_id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mail_tray', function (Blueprint $table) {
            $table->dropForeign('mail_tray_rfq_id_foreign');
            $table->dropForeign('mail_tray_vendor_id_foreign');
            $table->dropForeign('mail_tray_contact_id_foreign');
            $table->dropForeign('mail_tray_sent_by_foreign');
        });
    }
};
