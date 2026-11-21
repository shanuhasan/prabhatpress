<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One line of an order: Particular / Qty / Amount.
 */
class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'particular', 'qty', 'amount', 'sort'];

    protected $casts = [
        'qty' => 'integer',
        'amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
