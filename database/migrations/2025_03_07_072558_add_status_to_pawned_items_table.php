<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pawned_items', function (Blueprint $table) {
        $table->string('status')->default('active')->after('ticket_id');
        $table->decimal('remaining_balance', 10, 2)->default(0)->after('status');
    });
}


public function down()
{
    Schema::table('pawned_items', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

};
