<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('compony')->nullable();
            $table->string('particular');
            $table->string('order_book_no')->nullable();            
            $table->double('total_amount',10,2);
            $table->double('advance_amount',10,2)->nullable();
            $table->double('balance_amount',10,2)->nullable();
            $table->integer('is_pending_amount')->default(1);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
