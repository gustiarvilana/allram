<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'd_supplier';
    protected $guarded = [];

    public function getSupplier()
    {
        $supplier = DB::table('d_supplier');

        return $supplier;
    }
}
