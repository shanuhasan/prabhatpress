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
            $table->integer('customer_id')->nullable();
            $table->string('order_no')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('compony')->nullable();
            $table->string('particular');
            $table->integer('qty')->nullable();
            $table->string('order_book_no')->nullable();            
            $table->double('total_amount',10,2);
            $table->double('discount')->nullable();
            $table->double('advance_amount',10,2)->nullable();
            $table->double('balance_amount',10,2)->nullable();
            $table->integer('is_pending_amount')->default(1);
            $table->date('delivery_at')->nullable();
            $table->string('status')->nullable();
            $table->integer('payment_status')->default(0)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
