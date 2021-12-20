<?php

namespace App\Models\Supplier;


use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(SupplierProduct::class,"supplier_id","id");
    }

}
