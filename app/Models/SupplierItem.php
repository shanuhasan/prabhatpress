<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierItem extends Model
{
    use HasFactory;

    static public function findByGuid($guid)
    {
        return self::where('guid', $guid)->first();
    }

    static public function findSupplierId($id)
    {
        return self::where('supplier_id', $id)->get();
    }
}
