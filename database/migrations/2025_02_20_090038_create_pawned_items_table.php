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
                $table->id();
                $table->string('ticket_id', 6); // เปลี่ยนเป็น varchar(6) สำหรับหมายเลขตั๋ว
                $table->unsignedBigInteger('customer_id'); // เพิ่มคอลัมน์ customer_id
                $table->string('product_name');
                $table->decimal('amount', 10, 2);
                $table->decimal('interest_rate', 5, 2);
                $table->date('pawn_date');
                $table->date('due_date');
                $table->integer('pawn_duration');
                $table->timestamps();
            
                // เชื่อมโยงกับตาราง customers
                $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
                $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
                
                // หมายเหตุ: คุณไม่จำเป็นต้องใช้ foreign key สำหรับ ticket_id หากไม่ได้เชื่อมโยงกับตาราง tickets
                // ถ้าคุณต้องการให้ `ticket_id` ไม่เชื่อมโยงกับ `tickets` ก็สามารถลบคำสั่งนี้ได้
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
