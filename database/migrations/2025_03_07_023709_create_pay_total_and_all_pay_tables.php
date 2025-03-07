<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // ตารางเก็บยอดรวมที่ลูกค้าจ่ายแล้ว
        Schema::create('pay_total', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pawned_item_id')->constrained()->onDelete('cascade');
            $table->decimal('total_paid', 10, 2)->default(0); // ยอดรวมที่จ่ายแล้ว
            $table->timestamps();
        });

        // ตารางคำนวณยอดที่เหลือต้องจ่ายทั้งหมด
        Schema::create('all_pay', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pawned_item_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount_due', 10, 2)->default(0); // ยอดที่ต้องจ่ายทั้งหมด
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pay_total');
        Schema::dropIfExists('all_pay');
    }
};
