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
        Schema::table('orders',function(Blueprint $table){
            $table->string('order_no')->nullable()->after('id');
            $table->longText('address')->nullable()->after('phone');
            $table->integer('qty')->nullable()->after('particular');
            $table->integer('payment_status')->default(0)->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_no');
            $table->dropColumn('address');
            $table->dropColumn('qty');
            $table->dropColumn('payment_status');
        });
    }
};
