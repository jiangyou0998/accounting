<?php

namespace App\Models;


use App\Models\Supplier\SupplierProduct;
use Illuminate\Database\Eloquent\Model;

class SupplierGroup extends Model
{

    protected $table = 'supplier_groups';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(SupplierProduct::class,"group_id","id");
    }

}
