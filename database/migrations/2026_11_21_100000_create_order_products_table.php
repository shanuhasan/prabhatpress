<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Line items of an order (Particular / Qty / Amount).
 *
 * Not to be confused with `order_items`, which stores payments.
 * orders.particular / qty / total_amount are kept as a summary of these rows.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->index();
            $table->string('particular');
            $table->integer('qty')->nullable();
            $table->double('amount', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->timestamps();
        });

        // Backfill: every existing order becomes a single line item.
        DB::table('orders')->select('id', 'particular', 'qty', 'total_amount', 'created_at', 'updated_at')
            ->orderBy('id')
            ->chunk(500, function ($orders) {
                $rows = [];
                foreach ($orders as $order) {
                    $rows[] = [
                        'order_id' => $order->id,
                        'particular' => (string) ($order->particular ?? ''),
                        'qty' => $order->qty,
                        'amount' => (float) ($order->total_amount ?? 0),
                        'sort' => 0,
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ];
                }
                if ($rows) {
                    DB::table('order_products')->insert($rows);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
