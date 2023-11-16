<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public static function status()
    {
        $list = [
            '1'=>'Pending',
            '2'=>'Completed',
            '3'=>'Delivered',
            '4'=>'Cancelled',
        ];

        return $list;
    }
}
