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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();  // Create the primary key column

            // Add foreign key column
            $table->unsignedBigInteger('pawned_item_id');
            $table->foreign('pawned_item_id')->references('id')->on('pawned_items')->onDelete('cascade');

            // Add other columns for transactions
            $table->date('transaction_date');
            $table->decimal('backup_interest_rate', 5, 2);
            $table->decimal('amount_paid', 10, 2)->nullable();  // Amount can be null
            

            // Add timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
