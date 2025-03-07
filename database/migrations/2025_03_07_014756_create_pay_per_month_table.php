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
    Schema::create('pay_per_month', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pawned_item_id')->constrained('pawned_items')->onDelete('cascade'); // การเชื่อมโยงกับ pawned_items
        $table->decimal('monthly_payment', 15, 2); // จำนวนเงินที่ลูกค้าตกลงจ่ายต่อเดือน
        $table->decimal('interest', 15, 2); // ดอกเบี้ยต่อเดือน
        $table->decimal('total_monthly_payment', 15, 2); // จำนวนเงินรวมที่ต้องจ่ายในแต่ละเดือน (รวมดอกเบี้ย)
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('pay_per_month');
}

};
