<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    const EXPENSE = 'Expense';
    const HOME_EXPENSE = 'Home Expense';
    const IMRAN_EXPENSE = 'Imran Expense';
    const FURQAN_EXPENSE = 'Furqan Expense';

    public static function getExpenseList()
    {
        $list = [
            self::EXPENSE => self::EXPENSE,
            self::HOME_EXPENSE => self::HOME_EXPENSE,
            self::IMRAN_EXPENSE => self::IMRAN_EXPENSE,
            self::FURQAN_EXPENSE => self::FURQAN_EXPENSE,
        ];

        return $list;
    }
}
