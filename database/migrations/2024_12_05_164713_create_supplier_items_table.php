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
        Schema::create('supplier_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->longText('particular');
            $table->integer('qty')->nullable();
            $table->integer('size_1')->nullable();
            $table->integer('size_2')->nullable();
            $table->integer('size_3')->nullable();
            $table->integer('rate')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('balance_amount')->nullable();
            $table->string('is_mail')->nullable();
            $table->string('is_print_received')->nullable();
            $table->integer('type')->nullable();
            $table->string('field1')->nullable();
            $table->string('field2')->nullable();
            $table->string('field3')->nullable();
            $table->string('field4')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_items');
    }
};
