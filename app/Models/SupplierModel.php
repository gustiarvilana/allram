<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'd_supplier';
    protected $guarded = [];
}


function getSupplier() {
    $supplier = $this->model;
    dd($supplier);
    return $supplier;
}