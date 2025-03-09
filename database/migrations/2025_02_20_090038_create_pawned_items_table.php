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
    if (!Schema::hasTable('pawned_items')) {
        Schema::create('pawned_items', function (Blueprint $table) {
            $table->id();  // สร้างคอลัมน์ id ที่เป็น auto_increment
            $table->string('ticket_id', 10)->unique();  // กำหนดให้ ticket_id เป็น string มีความยาว 6 ตัวและ unique
            $table->unsignedBigInteger('customer_id');  // เพิ่มคอลัมน์ customer_id
            $table->string('product_name');
            $table->decimal('amount', 10, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->date('pawn_date');
            $table->date('due_date');
            $table->integer('pawn_duration');
            $table->text('description');
            $table->string('status')->default('active');
            $table->decimal('totalPayment', 10, 2)->default(0);;
            $table->decimal('remaining_balance', 10, 2)->default(0);
            $table->timestamps();

            // เชื่อมโยงกับตาราง customers
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pawned_items');
    }
};
